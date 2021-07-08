<?php

namespace App\Http\Controllers;

use App\Exports\PointBiserialExport;
use App\Imports\PointBiserialImport;
use App\Models\PointBiserial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PointBiserialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nilai= PointBiserial::all();

        //mean x1
        $X1 = DB::table('point_biserials')
        ->where('status', 'aktif')
        ->avg('nilai');

        //mean x2        
        $X2 = DB::table('point_biserials')
        ->where('status', 'non aktif')
        ->avg('nilai');

        // mean total
        $Xt = DB::table('point_biserials')->avg('nilai');
        

        $n =DB::table('point_biserials')
        ->where('status', 'aktif')
        ->count('nilai');
        
        $N = DB::table('point_biserials')->count('nilai');
        // cari p
        $p = $n/$N;
        //cari q
        $q = 1 - $p;

       // mencari SDt
        $sigma = 0;
        for ($i=0; $i < $N; $i++){
            $XminXt[$i] = $nilai[$i]->nilai - $Xt;
            $XminXtkuadrat[$i] = $XminXt[$i] * $XminXt[$i];
            $sigma += $XminXtkuadrat[$i];
        }
        $sdt = $sigma / ($N - 1);
        
        // korelasi point biserial rumus 1 dipake
        $PkaliX = ($p*$q); 
        $pengali = sqrt($PkaliX);
        $rbis = (($X1 - $X2)/$sdt)*$pengali;
        
        
        return view('pointbiserial', [
            'nilai'=>$nilai,
            'XminXt' => $XminXt,
            'XminXtKuadrat' => $XminXtkuadrat,
            'N'=> $N,
            'sigma'=>$sigma,
            'x1' => $X1,
            'x2' => $X2,
            'xt'=> $Xt,
            'sdt' => $sdt,
            'rbis'=>$rbis, 
            'p' => $p,
            'q' => $q

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
            'nilai' => 'required|numeric',
            'status' => 'required',

        ], $message);
        PointBiserial::create($validasi);
        return redirect('pointbiserial')->with([
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
        $nilai = PointBiserial::find($id);
        return view('editpointbiserial', compact('nilai'));
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
            'nilai' => 'required|numeric',
            'status' => 'required',

        ], $message);
        PointBiserial::where('id', $id)->update($validasi);
        return redirect('pointbiserial')->with([
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
        $nilai = PointBiserial::find($id);
        if ($nilai != null) {
            $nilai = PointBiserial::find($nilai->id);
            PointBiserial::where('id', $id)->delete();
        }
        return redirect('pointbiserial')->with([
            'deleted' => 'Data Berhasil Dihapus'
        ]);;
    }

    public function exportnilai()
    {
        return Excel::download(new PointBiserialExport, 'point_biserial.xlsx');
    }

    public function importnilai(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = $file->hashName();
        $path = $file->storeAs('public/excel/', $nama_file);
        $import = Excel::import(new PointBiserialImport(), storage_path('app/public/excel/' . $nama_file));
        Storage::delete($path);
        if ($import) {
            //redirect
            return redirect()->route('pointbiserial.index')->with(['success' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('pointbiserial.index')->with(['error' => 'Data Gagal Diimport!']);
        }
    }
}