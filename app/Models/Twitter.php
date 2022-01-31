<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twitter extends Model
{
    protected $fillable = [
        'text',
        'twitter_id'
    ];
    use HasFactory;
}
