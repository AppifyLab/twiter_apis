<?php

namespace App\Http\Controllers\Images;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\FetchingPost;
use Carbon\Carbon;
use App\Common\Customhelper;
use App\Models\ImageUpload;
use App\Http\Controllers\Social\SocialController;

use Illuminate\Support\Facades\Auth;


class ImagesController extends Controller
{

    private $imagesService;
    private $socialService;
    private $customHelper;
    public function __construct(ImagesService $imagesService,SocialController $socialService ,Customhelper $customHelper)
    {
        $this->imagesService = $imagesService;
        $this->socialService = $socialService;
        $this->customHelper = $customHelper;
    }
    //================================ Images-Start ========================================
    public function iviewShowImage(Request $request){
          // $blogImage=$request->file;
          


          $fileName = time().'.'.$request->file('file')->extension();
          $request->file('file')->move(public_path('img'), $fileName);
          $newPic='/img/'.$fileName;
           
          return response()->json($newPic);
    }

    public function showAllImages(Request $request){
        $data = $request->all();
        return $this->imagesService->showAllImages($data);
        // return ImageUpload::all()->where('user_id', $id);
    }
    public function imageUpload(Request $request){
        $data = $request->all();
        $id = Auth::user()->id;
        return ImageUpload::create([
            'user_id' => $id,
            'image' => $data['image']
        ]);
    }
    public function deleteImageRow(Request $request){
        $data = $request->all();
        return ImageUpload::where('id', $data['id'])->delete();
    }

    
    //================================ Images-End ========================================

  


}
