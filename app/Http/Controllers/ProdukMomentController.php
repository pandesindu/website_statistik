<?php

namespace App\Http\Controllers;

use App\Exports\ProdukMomentExport;
use App\Imports\ProdukMomentImport;
use App\Models\ProdukMoment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProdukMomentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $moments = ProdukMoment::all(); 
        $jumlahData = ProdukMoment::count();       
        $jumlahX = ProdukMoment::count('X_besar');   
        $jumlahY = ProdukMoment::count('Y_besar');
 
        $rata2X = ProdukMoment::average('X_besar');
        $rata2Y = ProdukMoment::average('Y_besar');
 
        $sumX = ProdukMoment::sum('X_besar');
        $sumY = ProdukMoment::sum('Y_besar');       
 
        $sumXKuadrat = 0;
        $sumYKuadrat = 0;
        $sumXY = 0;
        for ($i=0; $i < $jumlahX; $i++) {
 
             $xKecil[$i] = $moments[$i]->X_besar - $rata2X;
             $yKecil[$i] = $moments[$i]->Y_besar - $rata2Y;
            $xKuadrat[$i] = $xKecil[$i] * $xKecil[$i];             
            $sumXKuadrat += $xKuadrat[$i];           
 
            $yKuadrat[$i] = $yKecil[$i] * $yKecil[$i];   
            $sumYKuadrat += $yKuadrat[$i];
 
            $xKaliY[$i] = $xKecil[$i] * $yKecil[$i];                       
            $sumXY += $xKaliY[$i];
        }       
 
        //rumus
     //    $korelasimoment = $jumlahData*$sumXY - ($sumX)*($sumY)/sqrt(($jumlahData * $sumXKuadrat - pow($sumX, 2)) *($jumlahData*$sumYKuadrat - pow($sumY, 2)));       
        $korelasimoment = $sumXY/sqrt($sumXKuadrat*$sumYKuadrat);       
 
        return view('ProdukMoment', ['moments' => $moments,
                                         'jumlahData' => $jumlahData,
                                         'xKuadrat' => $xKuadrat,
                                         'yKuadrat' => $yKuadrat,
                                         'xKecil' => $xKecil,
                                         'yKecil' => $yKecil,
                                         'xKaliY' => $xKaliY,
                                         'sumX' => $sumX,
                                         'sumY' => $sumY,
                                         'sumXKuadrat' => $sumXKuadrat,
                                         'sumYKuadrat' => $sumYKuadrat,
                                         'sumXY' => $sumXY,
                                         'korelasimoment' => $korelasimoment,
                                         'rata2X' => $rata2X,
                                         'rata2Y' => $rata2Y,
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
            'X_besar' => 'required|max:10|numeric',
            'Y_besar' => 'required|max:10|numeric',

        ], $message);
        ProdukMoment::create($validasi);
        return redirect('produkmoment')->with([
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
        $nilai = ProdukMoment::find($id);
        return view('editprodukmoment', compact('nilai'));
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
            'X_besar' => 'required|max:10|numeric',
            'Y_besar' => 'required|max:10|numeric',

        ], $message);
        ProdukMoment::where('id', $id)->update($validasi);
        return redirect('produkmoment')->with([
            'updated' => 'Data Berhasil Diperbaharui'
        ]);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nilai = ProdukMoment::find($id);
        if ($nilai != null) {
            $nilai = ProdukMoment::find($nilai->id);
            ProdukMoment::where('id', $id)->delete();
        }
        return redirect('produkmoment')->with([
            'deleted' => 'Data Berhasil Dihapus'
        ]);;
    }


    public function exportnilai()
    {
        return Excel::download(new ProdukMomentExport, 'produk_moment.xlsx');
    }

    public function importnilai(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = $file->hashName();
        $path = $file->storeAs('public/excel/', $nama_file);
        $import = Excel::import(new ProdukMomentImport(), storage_path('app/public/excel/' . $nama_file));
        Storage::delete($path);
        if ($import) {
            //redirect
            return redirect()->route('produkmoment.index ')->with(['success' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('produkmoment.index ')->with(['error' => 'Data Gagal Diimport!']);
        }
    }
}