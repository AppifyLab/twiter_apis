<?php

namespace App\Http\Controllers\Images;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class ImagesService
{
    private $imagesQuery;
    public function __construct(ImagesQuery $imagesQuery)
    {
        $this->imagesQuery = $imagesQuery;
    }
    //================================ Images-Start ========================================
    public function showAllImages($data){
        $data['user_id'] =  Auth::id();
        return $this->imagesQuery->showAllImages($data);
    }
    
}
