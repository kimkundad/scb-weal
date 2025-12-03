<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participant_receipt extends Model
{
    use HasFactory;

    protected $fillable = [
    'phone',
    'prefix',
    'first_name',
    'last_name',
    'hbd',
    'id_type',
    'citizen_id',
    'passport_id',
    'email',
    'province',

    'purchase_date',
    'purchase_time',
    'receipt_number',
    'imei',
    'store_name',
    'receipt_file_path',
    'reject_reason',
    'status',
    'approved_at',
    'rejected_at',
    'checked_by',
];


    public function getUserNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    public function getReceiptNoAttribute(): ?string
    {
        return $this->receipt_number;
    }

    public function getModelAttribute(): ?string
    {
        return $this->store_name; // หรือฟิลด์อื่นที่คุณต้องการให้แสดงในคอลัมน์ "รุ่น"
    }

    public function getSubmittedAtAttribute()
    {
        return $this->purchase_date ?? $this->created_at;
    }

    public function logs()
    {
        return $this->hasMany(ParticipantReceiptLog::class, 'participant_receipt_id');
    }

}
