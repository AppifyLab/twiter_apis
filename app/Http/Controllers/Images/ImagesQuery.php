<?php

namespace App\Http\Controllers\Images;

use App\Models\Images;
use App\Models\User;
use App\Models\ImageUpload;
use Illuminate\Database\Eloquent\Builder;

class ImagesQuery
{
  
    //================================ Images-Start ========================================
    public function showAllImages($data){
        return ImageUpload::where('user_id', $data['user_id'])->orderBy('id', 'desc');
        // return ImageUpload::where('user_id', $data['user_id'])->orderBy('id', 'desc')->paginate(10);
        // return ImageUpload::create($data);
    }
}
