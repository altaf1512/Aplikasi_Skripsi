<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type', 'text'];

    public function expertRules()
    {
        return $this->hasMany(ExpertRule::class);
    }
}
