<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Berkelompok extends Controller
{
    public function databergolong(){

        $maxSkor = Nilai::max('nilai');
        $minSkor = Nilai::min('nilai');
        $n = Nilai::count('nilai');
        //mencari rentangan
        $rentangan = $maxSkor - $minSkor;

        //mencari kelas        
        $kelas = ceil(1 + 3.3 * log10 ($n));

        //menghitung interval
        $interval = ceil($rentangan/$kelas);        
        
        //set batas bawah dan batas atas
        $batasBawah = $minSkor;
        $batasAtas = 0;
        
        //data bergolong
        for($i = 0; $i < $kelas; $i++){
            $batasAtas = $batasBawah + $interval - 1;
             
            $frekuensi[$i] = Nilai::select(DB::raw('count(*) as frekuensi, nilai'))
                                    ->where([
                                        ['nilai', '>=', $batasBawah],
                                        ['nilai', '<=', $batasAtas],
                                    ])
                                    ->groupBy()                                                                                                    
                                    ->count();            
            $data[$i] = $batasBawah. " - ". $batasAtas;                                                          
            $batasBawah = $batasAtas + 1;
        }

    
        return view('databergolong', compact('data', 'kelas', 'frekuensi'));
    }
}