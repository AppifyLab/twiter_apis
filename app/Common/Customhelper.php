<?php

namespace App\Common;
use App\Models\Twitter;
use App\Models\User;
class Customhelper
{
    public function processImageAndUploadInstagram($data){
        $this->processImage($data->post->text);

        Twitter::where('id',$data->post->id)->where('is_published','!=','Completed')->update(['is_published'=>'Processing']);
        $this->uploadImageToInstagram($data->bussness_id, $data->fb_token);
        $this->upateProcessInfo($data);
        return 1;
    }

    public function processImage($text){
            $img = imagecreatefromjpeg(public_path('/img/test_png.jpeg'));
            $white = imagecolorallocate($img, 255, 255, 255);
            $txt_input =$text;
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
            $save=public_path('/img/converted.jpeg'); 
            imagepng($img,$save,0,NULL); 
            imagedestroy($img);
            return $save;
    }
    public function uploadImageToInstagram($bussness_id,$accessToken){
        $params = array( 
            'image_url' => 'https://inst.appifylab.com/img/converted.jpeg',
            'caption' => "testing ..",
            'access_token' => $accessToken
        );
        $response =  $this->sendCurlPostRequest("$bussness_id/media", $params);

        $publishImageEndpoint = "https://graph.facebook.com/v5.0/$bussness_id/media_publish";
        $params = array(
            'creation_id' =>  $response->id,
            'access_token' => $accessToken
        );

         $this->sendCurlPostRequest("$bussness_id/media_publish",$params);
         return 1;
    }

    public function upateProcessInfo($user){
        Twitter::where('id', $user->post->id)->update(['is_published'=>"Completed"]);
        User::where('id',$user->id)->update(['counter'=>$user->counter+1]);
    }

    public function sendCurlPostRequest($url,$params){
        $endpoint = "https://graph.facebook.com/v5.0/$url";
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $endpoint );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );
		
        $response  = json_decode($response);
        curl_close( $ch );
        return  $response ;
    }



    public function insertTweetIntoTheDatabase($data,$twetter_user){
             $array_data = [];
             \Log::info("hello");
            foreach($data as $key => $value){
                if(isset($value) && isset($value->entities) && isset($value->entities->urls[0]) && isset($value->entities->urls[0]->url)){
                    // $value->text = str_replace( $value->entities->urls[0]->url, '', $value->text);
                    continue;
                }
                if(isset($value) && isset($value->attachments)){
                    continue;
                }
                $like = 0;
                if($value->public_metrics){
                   if(isset($value->public_metrics->like_count)){
                        $like =$value->public_metrics->like_count;
                    }
                }
               
                array_push($array_data,[
                    'user_id'=>$twetter_user['user_id'],
                    'text'=>$value->text,
                    'twitter_id'=>$value->id,
                    'like'=>$like,
                    'create_time'=>$value->created_at
                ]);   
            }

            $sorted_array = $this->sortArrayByName($array_data);

            $this->insetTweet($sorted_array);
            return 1;
    }

    public  function sortArrayByName($inputArr) {

        $n = sizeof($inputArr);
        for ($i = 1; $i < $n; $i++) {
            $current = $inputArr[$i];
            $like = $inputArr[$i]['like'];
       
            $j = $i-1;

            while (($j > -1) && isset($inputArr[$j]['like']) && ($like > $inputArr[$j]['like'])) {
                $inputArr[$j+1] = $inputArr[$j];
                $j--;
            }
            $inputArr[$j+1] = $current;
        }
        return $inputArr;
        
    }

    public function insetTweet($array_data){
            $i =1;
            foreach($array_data as $key => $value){
                Twitter::create($value);
                $i++;
                if($i>25){
                     break;
                }
            }

    }

   


}