<?php

namespace App\Http\Controllers\FontAndColor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class FontAndColorService
{
    private $fontandcolorQuery;
    public function __construct(FontAndColorQuery $fontandcolorQuery)
    {
        $this->fontandcolorQuery = $fontandcolorQuery;
    }
    //================================ FontAndColor-Start ========================================
    public function showAllFontAndColor($data){
        $data['user_id'] =  Auth::id();
        return $this->fontandcolorQuery->showAllFontAndColor($data);
    }
    
}
