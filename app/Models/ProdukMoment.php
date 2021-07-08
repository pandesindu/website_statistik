<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukMoment extends Model
{
    use HasFactory;
    protected $fillable= [
        'X_besar', 'Y_besar'
    ];
}