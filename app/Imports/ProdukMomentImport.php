<?php

namespace App\Imports;


use App\Models\ProdukMoment;
use Maatwebsite\Excel\Concerns\ToModel;

class ProdukMomentImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ProdukMoment([
            'id'     => $row[0],
            'X_besar'    => $row[1],
            'Y_besar'    => $row[2],
        ]);
    }
}