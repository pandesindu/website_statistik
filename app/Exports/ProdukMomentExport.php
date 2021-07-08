<?php

namespace App\Exports;

use App\Models\ProdukMoment;
use Maatwebsite\Excel\Concerns\FromCollection;


class ProdukMomentExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ProdukMoment::all();
    }
}