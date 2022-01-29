<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_name'
    ];

    protected $hidden = ['pivot'];
    // public function infoCategories()
    // {
    //     return $this->belongsToMany(Information::class, 'challenge_categories')->withTimestamps();
    // }
}
