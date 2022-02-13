<?php

namespace App\Http\Controllers\FontAndColor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\FetchingPost;
use Carbon\Carbon;
use App\Common\Customhelper;
use App\Models\ImageUpload;
use App\Http\Controllers\Social\SocialController;
use App\Models\FontAndColor;
use Illuminate\Support\Facades\Auth;


class FontAndColorController extends Controller
{

    private $fontandcolorService;
    private $socialService;
    private $customHelper;
    public function __construct(FontAndColorService $fontandcolorService,SocialController $socialService ,Customhelper $customHelper)
    {
        $this->fontandcolorService = $fontandcolorService;
        $this->socialService = $socialService;
        $this->customHelper = $customHelper;
    }
    //================================ FontAndColor-Start ========================================
    public function addFontAndColor(Request $request){
        $data = $request->all();
        $id = Auth::user()->id;

        $data['user_id'] = $id;

        return FontAndColor::updateOrCreate(
            ['user_id' => $id],
            $data
        );
    }
    public function viewFontAndColor(Request $request){
        $id = Auth::user()->id;
        return FontAndColor::where('user_id', $id)->get();
    }

    
    //================================ FontAndColor-End ========================================

  


}
