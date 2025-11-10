<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participant_receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone', 'first_name', 'last_name', 'email', 'province',
        'purchase_date', 'purchase_time', 'receipt_number', 'imei',
        'store_name', 'receipt_file_path', 'status'
    ];
}
