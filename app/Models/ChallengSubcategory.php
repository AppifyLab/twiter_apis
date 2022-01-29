<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengSubcategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'information_id',
        'subcategory_id',
    ];
}
