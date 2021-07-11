<?php

namespace App\Imports;

use App\Models\UjiT;
use Maatwebsite\Excel\Concerns\ToModel;

class UjiTImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new UjiT([
            'id'     => $row[0],
            'x1'    => $row[1],
            'x2'    => $row[2],
        ]);
    }
}