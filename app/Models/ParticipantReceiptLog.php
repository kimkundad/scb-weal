<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantReceiptLog extends Model
{
    protected $fillable = [
        'participant_receipt_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
    ];

    public function receipt()
    {
        return $this->belongsTo(participant_receipt::class, 'participant_receipt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
