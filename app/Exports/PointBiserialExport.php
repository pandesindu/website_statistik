<?php

namespace App\Exports;

use App\Models\PointBiserial;
use App\Models\ProdukMoment;
use Maatwebsite\Excel\Concerns\FromCollection;


class PointBiserialExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PointBiserial::all();
    }
}