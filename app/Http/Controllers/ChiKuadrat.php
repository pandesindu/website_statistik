<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\TabelZ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ChiKuadrat extends Controller
{
    public function chikuadrat(){

        $maxSkor = Nilai::max('nilai');
        $minSkor = Nilai::min('nilai');
        //$n = f0 = banyak skor/total frekuensi
        $n = Nilai::count('nilai');
        $rata2 = number_format(Nilai::average('nilai'), 2);

        //function standar deviasi
        function std_deviation($my_arr){
            $no_element = count($my_arr);
            $var = 0.0;
            $avg = array_sum($my_arr)/$no_element;
            foreach($my_arr as $i)
                {
                    $var += pow(($i - $avg), 2);
                }
            return (float)sqrt($var/$no_element);
        }

        //function desimal
        function desimal($nilai){
            if($nilai<0){
                $des = substr($nilai,0,4);
            } else {
                $des = substr($nilai,0,3);
            }
            return $des;
        }

        //function label
        function label($nilai){
            if($nilai<0){
                $str1 = substr($nilai,4,1);
            } else {
                $str1 = substr($nilai,3,1);
            }

            switch($str1){
                case '0': 
                    $sLabel = 'nol';
                    break;
                case '1': 
                    $sLabel = 'satu';
                    break;
                case '2': 
                    $sLabel = 'dua';
                    break;
                case '3': 
                    $sLabel = 'tiga';
                    break;
                case '4': 
                    $sLabel = 'empat';
                    break;
                case '5': 
                    $sLabel = 'lima';
                    break;
                case '6': 
                    $sLabel = 'enam';
                    break;
                case '7': 
                    $sLabel = 'tujuh';
                    break;
                case '8': 
                    $sLabel = 'delapan';
                    break;
                case '9': 
                    $sLabel = 'sembilan';
                    break;
                default: $sLabel = 'Tidak ada field';
            }
            
            return $sLabel;
        }

        //ambil nilai skor
        $value = Nilai::select('nilai')->get();

        //masukin skor ke dalam array biar bsa dipakek sama functionnya
        $i = 0;
        foreach ($value as $a){
            $arraySkor[$i] = $a->nilai;
            $i++;            
        }                         
           
        //standar deviasi dari seluruh skor
        $SD = number_format(std_deviation($arraySkor), 2);                            
        
        //mencari rentangan
        $rentangan = $maxSkor - $minSkor;

        //mencari kelas        
        $kelas = ceil(1 + 3.3 * log10 ($n));

        //menghitung interval
        $interval = ceil($rentangan/$kelas);        
        
        //set batas bawah dan batas atas
        $batasBawah = $minSkor;
        $batasAtas = 0;
        
        //data chi
        $totalchi = 0;
        for($i = 0; $i < $kelas; $i++){
            //menghitung batas bawah
            $batasBawahBaru[$i] = $batasBawah - 0.5;            
            
            $batasAtas = $batasBawah + $interval - 1;

            //menghitung batas atas
            $batasAtasBaru[$i] = $batasAtas + 0.5;
                                    
            //menghitung atas dan bawah z
            $zBawah[$i] = number_format(($batasBawahBaru[$i]- $rata2)/$SD, 2);
            $zAtas[$i] = number_format(($batasAtasBaru[$i]- $rata2)/$SD, 2);                       

            //menghitung z tabel atas dan bawah
            $cariDesimalBawah = desimal($zBawah[$i]);
            $cariDesimalAtas = desimal($zAtas[$i]);

            $labelDesimalBawah = label($zBawah[$i]);            
            $labelDesimalAtas= label($zAtas[$i]);                                                           

            $zTabelBawah = TabelZ::where('z', '=', $cariDesimalBawah)->get(); 
            $zTabelAtas = TabelZ::where('z', '=', $cariDesimalAtas)->get();                     
            $zTabelBawahFix[$i] = $zTabelBawah[0]->$labelDesimalBawah;
            $zTabelAtasFix[$i] = $zTabelAtas[0]->$labelDesimalAtas;            
            
            //menghitung l/proporsi
            $lprop[$i] = abs($zTabelBawahFix[$i] - $zTabelAtasFix[$i]);

            //menghitung fe(L*N)
            $fe[$i] = $lprop[$i]*$n;              

            //menghitung f0
            $frekuensi[$i] = Nilai::select(DB::raw('count(*) as frekuensi, nilai'))
                                    ->where([
                                        ['nilai', '>=', $batasBawah],
                                        ['nilai', '<=', $batasAtas],
                                    ])
                                    ->groupBy()                                                                                                    
                                    ->count();            
            $data[$i] = $batasBawah. " - ". $batasAtas;                                                          
            $batasBawah = $batasAtas + 1;
            
            //menghitung (f0-fe)^2/fe
            $kai[$i] = number_format(pow(($frekuensi[$i] - $fe[$i]),2)/$fe[$i], 7);
            $totalchi += $kai[$i];                        
        }
       
                

        return view ('chi-kuadrat', ['data' => $data,
                                        'frekuensi' => $frekuensi,
                                        'batasAtas' => $batasAtas,
                                        'batasBawah' => $batasBawah,
                                        'kelas' => $kelas,
                                        'interval' => $interval,
                                        'rentangan' => $rentangan,
                                        'batasBawahBaru' => $batasBawahBaru,    
                                        'batasAtasBaru' => $batasAtasBaru,
                                        'zBawah' => $zBawah, 
                                        'zAtas' => $zAtas, 
                                        'zTabelBawahFix' => $zTabelBawahFix,
                                        'zTabelAtasFix' => $zTabelAtasFix,
                                        'lprop' => $lprop,
                                        'fe' => $fe,
                                        'kai' => $kai,
                                        'totalchi' => $totalchi,                                                                        
                                        ]);
   }

}