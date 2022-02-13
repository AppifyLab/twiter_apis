<?php

namespace App\Http\Controllers\FontAndColor;

use App\Models\FontAndColor;
use App\Models\User;
use App\Models\ImageUpload;
use Illuminate\Database\Eloquent\Builder;

class FontAndColorQuery
{
  
    //================================ FontAndColor-Start ========================================
    public function showAllFontAndColor($data){
        return ImageUpload::where('user_id', $data['user_id'])->orderBy('id', 'desc')->paginate(10);
        // return ImageUpload::create($data);
    }
}
