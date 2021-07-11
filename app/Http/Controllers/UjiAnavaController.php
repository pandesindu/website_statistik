<?php

namespace App\Http\Controllers;

use App\Exports\UjiAnavaExport;

use App\Imports\UjiAnavaImport;
use App\Models\Tb_F;
use App\Models\UjiAnava;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UjiAnavaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anava = UjiAnava::all();  
        $jumlahData = UjiAnava::count();

        // sum dan avg data normal
        $sumX1 = UjiAnava::sum('x1');
        $avgX1 = UjiAnava::avg('x1');
        $sumX2 = UjiAnava::sum('x2');
        $avgX2 = UjiAnava::avg('x2');
        $sumX3 = UjiAnava::sum('x3');
        $avgX3 = UjiAnava::avg('x3');

        //mencari count x per kelompok data 
        $nx1 = UjiAnava::count('x1');
        $nx2 = UjiAnava::count('x2');
        $nx3 = UjiAnava::count('x3');

        //jumlah semua data 
        $N = $nx1+ $nx2+ $nx3;

        //jumlah kelompok data 
        $k = 3;

        //selesaikan tabel datanya 
        $sigmaX1kuadrat = 0;
        $sigmaX2kuadrat = 0;
        $sigmaX3kuadrat = 0;
        $sigmaXtotal = 0;
        $sigmaXtotalkuadrat = 0;

      

        for ($i=0; $i < $jumlahData; $i++){
            $X1kuadrat[$i] = $anava[$i]->x1 * $anava[$i]->x1;
            $X2kuadrat[$i] = $anava[$i]->x2 * $anava[$i]->x2;
            $X3kuadrat[$i] = $anava[$i]->x3 * $anava[$i]->x3;

            $sigmaX1kuadrat += $X1kuadrat[$i];
            $sigmaX2kuadrat += $X2kuadrat[$i];
            $sigmaX3kuadrat += $X3kuadrat[$i];

            // mencari Xtotal
            $Xtotal[$i] = $anava[$i]->x1 + $anava[$i]->x2 + $anava[$i]->x3;
            $XtotalKuadrat[$i] =  $Xtotal[$i] * $Xtotal[$i];

            $sigmaXtotal += $Xtotal[$i];
            $sigmaXtotalkuadrat += $XtotalKuadrat[$i];
        }
    

        //mencari JKa (Jumlah Kuadrat Antara) rumus sigma xperkelompok * n x per kelompok
        if($nx1 !== 0 ){
            $a1 =  ($sumX1/$nx1);
        }else {
            $a1 = 0;
        }

        if($nx2 !== 0 ){
            $a2 =  ($sumX2/$nx2);
        }else {
            $a2 = 0;
        }

        
        if($nx3 !== 0 ){
            $a3 =  ($sumX3/$nx3);
        }else {
            $a3 = 0;
        }

        if($N !== 0 ){
            $a4 =  ($sigmaXtotal/$N);
        }else {
            $a4 = 0;
        }


        $JKA =  $a1 + $a2 + $a3 - $a4;

        // mencari DKA 
        $DKA = $k - 1;

        // mencari RJKA Rerata Jumlah Kuadrat Antara
        if($DKA !== 0 ){
            $RJKA = $JKA/$DKA;
        } else {
            $RJKA = 0;
        }
        

        // mencari JKt
        $sigmaYkuadrat = $sigmaX1kuadrat + $sigmaX2kuadrat + $sigmaX3kuadrat;

        if ($N !== 0) { 
            $JKT = $sigmaYkuadrat - (($sigmaXtotal * $sigmaXtotal)/$N);
        } else {
            $JKT =0;
        }  
        

        //mencari  Jumlah Kuadrat Dalam (JKD)
        $JKD = $JKT - $JKA;

        //mencari DKD
        $DKD = $N - $k;

        // mencari RJKD Rerata Jumlah Kuadrat Dalam
        if($DKD !== 0) { 
            $RJKD = $JKD/$DKD;  
        } else {
            $RJKD = 0;
        }
        

        // uji F
        if($RJKD !== 0 ){ 
            $F = $RJKA/ $RJKD;
        }else{
            $F = 0;
        }
        

        $DKT = $DKD + $DKA;

        // dd($F);
        //mengecek tabel f, butuh $DKA dan $DKD
        //function cek label
        function label($nilai){            

            switch($nilai){
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
                default: $sLabel = 'Tidak ada field';
            }
            
            return $sLabel;
        }

        //1. cek label
        $labelDKA = label($DKA);
        
        //2. cek di tabel f
        $kolom = Tb_F::where('df1', '=', $DKD)->get();                 
        $fTabel = $kolom[0]->$labelDKA;               

        //cek keterangan
        if ($F > $fTabel){
            $status =  "Signifikan";
        } else {
            $status =   "Tidak Signifikan";
        }

        return view('ujianava', ['anava' => $anava,
                                'jumlahData'=>$jumlahData,

                                'x1kuadrat' => $X1kuadrat,
                                'x2kuadrat'=> $X2kuadrat,
                                'x3kuadrat'=>$X3kuadrat,
                                'xtotal'=>$Xtotal,
                                'xtotalkuadrat' =>$XtotalKuadrat,

                                'sumX1' =>$sumX1,
                                'sumX2' =>$sumX2,
                                'sumX3' =>$sumX3,
                                'avgX1' =>$avgX1,
                                'avgX2' =>$avgX2,
                                'avgX3' =>$avgX3,
                                'sumxtotal'=>$sigmaXtotal,
                                'sumxtotalkuadrat'=>$sigmaXtotalkuadrat,

                                'sigmaX1kuadrat' => $sigmaX1kuadrat,
                                'sigmaX2kuadrat' => $sigmaX2kuadrat,
                                'sigmaX3kuadrat' => $sigmaX3kuadrat,

                                // antar
                                'JKA' => $JKA,
                                'DKA'=>$DKA,
                                'RJKA'=>$RJKA,
                                'F'=>$F,

                                //dalam 
                                'jkd' => $JKD, 
                                'dkd'=> $DKD,
                                'rjkd' => $RJKD,

                                // total 
                                'jkt' => $JKT, 
                                'dkt' => $DKT, 
                                
                                 //ftabel
                                 'fTabel' => $fTabel,

                                 //status
                                 'status' => $status,

                                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'required' => 'kolom harus diisi',
            'date' => 'harus berupa tanggal',
            'numeric' => 'input harus berupa angka'

        ];
        $validasi = $request->validate([
            'x1' => 'required|numeric',
            'x2' => 'required|numeric',
            'x3' => 'required|numeric',

        ], $message);
        UjiAnava::create($validasi);
        return redirect('anava')->with([
            'success' => 'Data Tersimpan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nilai = UjiAnava::find($id);
        return view('editanava', compact('nilai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = [
            'required' => 'kolom harus diisi',
            'numeric' => 'input harus berupa angka'

        ];
        $validasi = $request->validate([
            'x1' => 'required|numeric',
            'x2' => 'required|numeric',
            'x3' => 'required|numeric',

        ], $message);
        UjiAnava::where('id', $id)->update($validasi);
        return redirect('anava')->with([
            'updated' => 'Data Berhasil Diperbaharui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nilai = UjiAnava::find($id);
        if ($nilai != null) {
            $nilai = UjiAnava::find($nilai->id);
             UjiAnava::where('id', $id)->delete();
        }
        return redirect('anava')->with([
            'deleted' => 'Data Berhasil Dihapus'
        ]);;
    }

    public function exportnilai()
    {
        return Excel::download(new UjiAnavaExport, 'uji_anava.xlsx');
    }

    public function importnilai(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = $file->hashName();
        $path = $file->storeAs('public/excel/', $nama_file);
        $import = Excel::import(new UjiAnavaImport(), storage_path('app/public/excel/' . $nama_file));
        Storage::delete($path);
        if ($import) {
            //redirect
            return redirect()->route('anava.index')->with(['success' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('anava.index')->with(['error' => 'Data Gagal Diimport!']);
        }
    }

    
}