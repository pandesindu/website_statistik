<?php

namespace App\Imports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\ToModel;

class NilaisImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Nilai([
            'id'     => $row[0],
            'nilai'    => $row[1],
        ]);
    }
}