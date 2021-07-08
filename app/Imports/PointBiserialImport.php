<?php

namespace App\Imports;

use App\Models\PointBiserial;
use App\Models\ProdukMoment;
use Maatwebsite\Excel\Concerns\ToModel;

class PointBiserialImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PointBiserial([
            'id'     => $row[0],
            'nilai'    => $row[1],
            'status'    => $row[2],
        ]);
    }
}