<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use App\Nilai;
use App\Models\Nilai as Data;

class NilaisExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Data::all();
    }
}