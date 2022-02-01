<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'username','user_id','twitter_user_id'
    ];

    protected $hidden = ['pivot'];
    // public function infoCategories()
    // {
    //     return $this->belongsToMany(Information::class, 'challenge_categories')->withTimestamps();
    // }
}
