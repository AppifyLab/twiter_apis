<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $fillable = [
        'action',
        'challenge',
        'address',
        'phone',
        'food_type',
        'description',
        'website',
        'star_rating',
        'google_ratings',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'challenge_categories')->withTimestamps();
    }
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'challeng_subcategories')->withTimestamps();
    }
    public function subSubcategories()
    {
        return $this->belongsToMany(SubSubcategory::class, 'challenge_subsubcategories')->withTimestamps();
    }
}
