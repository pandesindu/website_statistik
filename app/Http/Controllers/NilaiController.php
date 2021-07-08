<?php

namespace App\Http\Controllers;

use App\Exports\NilaisExport;
use App\Imports\NilaisImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rata = DB::table('nilai')->avg('nilai');
        $min = DB::table('nilai')->min('nilai');
        $max = DB::table('nilai')->max('nilai');
        $count = DB::table('nilai')->select('nilai', DB::raw('count(*) as frek'))->groupBy('nilai')->get();

        return view('dasboard', [
            'nilai' =>Nilai::latest()->simplePaginate(10), 
            'max'=>$max, 
            'min'=>$min, 
            'rata'=>$rata, 
            'count'=>$count
        ]);
    }
    
    public function exportnilai()
    {
        return Excel::download(new NilaisExport, 'nilai.xlsx');
    }

    public function importnilai(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = $file->hashName();
        $path = $file->storeAs('public/excel/', $nama_file);
        $import = Excel::import(new NilaisImport(), storage_path('app/public/excel/' . $nama_file));
        Storage::delete($path);
        if ($import) {
            //redirect
            return redirect()->route('nilai.index')->with(['success' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('nilai.index')->with(['error' => 'Data Gagal Diimport!']);
        }
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
            'nilai' => 'required|max:10',

        ], $message);
        Nilai::create($validasi);
        return redirect('nilai')->with([
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
        $nilai = Nilai::find($id);
        return view('edit', compact('nilai'));
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
            'date' => 'harus berupa tanggal',
            'numeric' => 'input harus berupa angka'

        ];
        $validasi = $request->validate([
            'nilai' => 'required|max:10',

        ], $message);
        Nilai::where('id', $id)->update($validasi);
        return redirect('nilai')->with([
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
        $nilai = Nilai::find($id);
        if ($nilai != null) {
            $nilai = Nilai::find($nilai->id);
            Nilai::where('id', $id)->delete();
        }
        return redirect('nilai')->with([
            'deleted' => 'Data Berhasil Dihapus'
        ]);;
    }

    public function delete()
    {
        Nilai::all()->delete();
        return redirect('nilai');
    }
}