<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HonorImei extends Model
{
    use HasFactory;

     protected $table = 'honor_imei_list';

    protected $fillable = [
        'imei',
    ];
}
