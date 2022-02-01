<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Image;
use File;
use Facebook\Facebook;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{






    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function makeimage()  
    {  
        $file = Input::file('/img/avater.png');
       $img = Image::make($file->getRealPath());  
    //    $img->text('This is a example ', 120, 100);  
       return "hello";
       $img->save(public_path('images/hardik3.jpg'));  
    }  

    public function backgroundImage(){
        header('Content-type: image/png');
            $img = imagecreatefromjpeg('/Users/appifylab_01/laravel_project/mytestapp/public/img/salman.jpeg');
            $white = imagecolorallocate($img, 255, 255, 255);
            $txt_input = "ODI squad: Rohit Sharma (Capt), KL Rahul (vc), Ruturaj Gaikwad, Shikhar, Virat Kohli, Surya Kumar Yadav, Shreyas Iyer, Deepak Hooda, Rishabh Pant (wk), D Chahar, Shardul Thakur, Y Chahal,Kuldeep Kuldeep Yadav, Washington Sundar, Ravi Bishnoi, Mohd. Siraj, Prasidh Krishna, Avesh Khan";
            $txt_input .= " ODI squad: Rohit Sharma (Capt), KL Rahul (vc), Ruturaj Gaikwad, Shikhar, Virat Kohli, Surya Kumar Yadav, Shreyas Iyer, Deepak Hooda, Rishabh Pant (wk), D Chahar, Shardul Thakur, Y Chahal,Kuldeep Kuldeep Yadav, Washington Sundar, Ravi Bishnoi, Mohd. Siraj, Prasidh Krishna, Avesh Khan";
            
            // return  sizeof($txt_input);
            $txt = wordwrap($txt_input, 50, "\n", TRUE);
            $font = public_path('/font/Roboto-Regular.ttf'); 
            $font_size = 35;
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
                imagettftext($img, $font_size, $angle, $x, $y, $text_color, $font, $text);
                // break;
            }
            // OUTPUT IMAGE


            // header('Content-type: image/jpeg');
            //       header("Cache-Control: no-store, no-cache");  
            //       header('Content-Disposition: attachment; filename="inst_back_temp.jpg"');
                  
            // imagejpeg($img);
            $save=public_path('/img/new23.png'); 
            imagepng($img,$save,0,NULL); 
            imagedestroy($img);

          
}



        public function test (){
        header('Content-type: image/png');

            // Create the image
            $im = imagecreatetruecolor(400, 30);

            // Create some colors
            $white = imagecolorallocate($im, 255, 255, 255);
            $grey = imagecolorallocate($im, 128, 128, 128);
            $black = imagecolorallocate($im, 0, 0, 0);
            imagefilledrectangle($im, 0, 0, 399, 200, $white);

            // The text to draw
            $text = 'Testing...';
            // Replace path by your own font path
            $font = public_path('/font/Roboto-Bold.ttf');

            // Add some shadow to the text
            imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

            // Add the text
            imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

            // Using imagepng() results in clearer text compared with imagejpeg()
            // $a=    imagepng($im);
        //  imagedestroy($im);
        // $img = Image::make ($a);
        $save=public_path('/img/new1.png'); 
        imagepng($im,$save,0,NULL); imagedestroy($im);
        return "ok";
    }
    public function getPost(){

     

        
       $img = Image::make('/Users/appifylab_01/laravel_project/admin_panel/public/img/test.jpeg');  
       $img->text('Sadek ahmed',1000,1000,function($font) {
        $font->file(public_path('/font/Roboto-Bold.ttf'));
        $font->color('#FF0000');
        $font->align('center');
        $font->size(500);
    
       });  
    
    //    $img->text('This mdnfsdflkasjdf asdfjasdjf', 0, 0, function($font) {
    //     $font->color([255, 255, 255, 0.5]);
    // https://pro.fontawesome.com/releases/v5.10.0/css/all.css
    //     $font->align('center');
    // });
  
       $img->save(public_path('img/test9.png')); 
       return "susce3";
    }
    public function login(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'email'   => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ],[
            'email.exists' => "Invalid Creadentials.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }

        return $this->authService->login($data);
    }
    public function register(Request $request){
        $data = $request->all();
        $user =  $this->authService->register($data);
        if($user){
           return $this->authService->login($data);
        }
        else {
            return response()->json([
                'messages' => "Invalid request"
            ], 401);
        }
    }

    

    public function logout(){
         Auth::logout();
         return response()->json(['message' => 'Logout Successfully !'], 200);
    }
    public function authUser(){
        return Auth::user();
    }

}
