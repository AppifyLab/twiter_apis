<?php

namespace App\Http\Controllers\Example;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Twitter;
use App\Models\User;
use App\Models\Category;
use App\Models\FontAndColor;
use Carbon\Carbon;
use App\Models\ImageUpload;
use Illuminate\Support\Facades\Auth;

class ExampleController extends Controller
{

    private $exampleService;
    public function __construct(ExampleService $exampleService)
    {
        $this->exampleService = $exampleService;
    }
    public function processImage($text = "Hi"){
        $id = Auth::user()->id;
        
        $image = ImageUpload::where('user_id', $id)->inRandomOrder()->limit(1)->first();
        $fontAndColor = FontAndColor::where('user_id', $id)->first();

        $resStr = str_replace('rgba(', '', $fontAndColor->color);
        $rgbWithComa = str_replace(')', '', $resStr);
        $rgb = explode (",", $rgbWithComa); 

        // return $rgb;

        $img = imagecreatefromjpeg(public_path($image->image));
        $white = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
        $txt_input =$text;
        $txt = wordwrap($txt_input, 50, "\n", TRUE);
        // $font = public_path('/font/Roboto-Regular.ttf'); 
        $font = public_path($fontAndColor->font); 
        $font_size = 30;
        $angle = 0;
        $text_color = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
        // THE IMAGE SIZE
        $width = imagesx($img);
        $height = imagesy($img);
        $splittext = explode ( "\n" , $txt );
        $lines = count($splittext);
              $i = 0;
        foreach ($splittext as $text) {
            $text_box = imagettfbbox($font_size, $angle, $font, $txt);
            $text_width = abs(max($text_box[2], $text_box[4]));
            $text_height = abs(max($text_box[5], $text_box[7]));
            // $x = 0;
            $x = (imagesx($img) - $text_width)/2;
            $y = ((imagesy($img) + $text_height)/2)-($lines-2)*$text_height-30;
            // $y = ((imagesy($img) + $text_height)/2);
            $lines=$lines-1;
            $y = $y+$i*30;
            $i++;
            $black = imagecolorallocate($img,0,0,0);
           
            imagettftext($img, $font_size, 0, $x+5, $y+5, $black, $font, $text);
            imagettftext($img, $font_size, $angle, $x, $y, $text_color, $font, $text);
            // break;
        }
        $save=public_path('/img/converted.jpeg'); 
        imagepng($img,$save,0,NULL); 
        imagedestroy($img);
        return $save;
}

    public function processImage1(){
        $text = "Joy";
        $id = Auth::user()->id;
        
        $image = ImageUpload::where('user_id', $id)->inRandomOrder()->limit(1)->first();
        // return $image->image;
        $img ='';
        if($image->image){
            $img = imagecreatefromjpeg(public_path($image->image));
        }

       

        $white = imagecolorallocate($img, 255, 255, 255);
        $txt_input =$text;
        $txt = wordwrap($txt_input, 50, "\n", TRUE);
        // $font = public_path('/font/Roboto-Regular.ttf'); 
        $font = public_path('/font/Roboto-Bold.ttf'); 
        $font_size = 30;
        $angle = 0;
        $text_color = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
        // THE IMAGE SIZE
        $width = imagesx($img);
        $height = imagesy($img);
        $splittext = explode ( "\n" , $txt );
        $lines = count($splittext);
              $i = 0;
        foreach ($splittext as $text) {
            $text_box = imagettfbbox($font_size, $angle, $font, $txt);
            $text_width = abs(max($text_box[2], $text_box[4]));
            $text_height = abs(max($text_box[5], $text_box[7]));
            // $x = 0;
            $x = (imagesx($img) - $text_width)/2;
            $y = ((imagesy($img) + $text_height)/2)-($lines-2)*$text_height-30;
            // $y = ((imagesy($img) + $text_height)/2);
            $lines=$lines-1;
            $y = $y+$i*30;
            $i++;
            $black = imagecolorallocate($img,0,0,0);
           
            imagettftext($img, $font_size, 0, $x+5, $y+5, $black, $font, $text);
            imagettftext($img, $font_size, $angle, $x, $y, $text_color, $font, $text);
            // break;
        }
        $save=public_path('/img/converted.jpeg'); 
        imagepng($img,$save,0,NULL); 
        imagedestroy($img);
        return $save;
}

}
