<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationHistory extends Model
{
    protected $guarded = [];

    protected $casts = [
        'input_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
