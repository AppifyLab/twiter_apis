<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeSubsubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_id',
        'subcategory_id',
    ];
}
