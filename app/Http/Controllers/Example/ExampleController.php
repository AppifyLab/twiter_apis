<?php

namespace App\Http\Controllers\Example;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{

    private $exampleService;
    public function __construct(ExampleService $exampleService)
    {
        $this->exampleService = $exampleService;
    }
    public function exampleMethod(){
        // return "hello";

        $text ="Twitter also points out that the use of “please” and “thank you” have increased over the year since the character count change, by 54% and 22%, respectively. But don’t take those metrics to mean that Twitter’s community itself has a kinder, gentler tone. Sentimentsd sdfadsdfa dsa";
        $img = imagecreatefromjpeg(public_path('/img/test_png.jpeg'));
        $white = imagecolorallocate($img, 255, 255, 255);
        $txt_input =$text;
        $txt = wordwrap($txt_input, 50, "\n", TRUE);
        // $font = public_path('/font/Roboto-Regular.ttf'); 
        $font1 = public_path('/font/Roboto-Bold.ttf'); 
        $font_size = 30;
        $font_size1 = 35;
        $angle = 0;
        $text_color = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
        
        // THE IMAGE SIZE
        $width = imagesx($img);
        $height = imagesy($img);
        $splittext = explode ( "\n" , $txt );
        $lines = count($splittext);
        $i = 0;
        foreach ($splittext as $text) {
            $text_box = imagettfbbox($font_size, $angle, $font1, $txt);
            $text_width = abs(max($text_box[2], $text_box[4]));
            $text_height = abs(max($text_box[5], $text_box[7]));
            // $x = 0;
            $x = (imagesx($img) - $text_width)/2;
            $y = ((imagesy($img) + $text_height)/2)-($lines-2)*$text_height-30;
            // $y = ((imagesy($img) + $text_height)/2);
            $lines=$lines-1;
            $y = $y+$i*30;
            $i++;
            $gray = imagecolorallocate($img,128,128,128);
            $red = imagecolorallocate($img,255,0,0);
            $black = imagecolorallocate($img,0,0,0);
            
            //Write Shadow
            $grey = imagecolorallocate($img,100,100,100);
            imagettftext($img, $font_size, 0, $x+5, $y+5, $black, $font1, $text);

            //Write Text
            // imagettftext($img, $font_size, $angle, $x, $y, $text_color, $font, $text);
            Imagettftext($img, $font_size, $angle, $x, $y,$white,$font1,$text );
            // imagettftextblur($img,$font_size,0,$x + 3,$y + 3,$text_color,$font,$text); 
        }
        $save=public_path('/img/converted.jpeg'); 
        imagepng($img,$save,0,NULL); 
        imagedestroy($img);
        return $save;



    }


}
