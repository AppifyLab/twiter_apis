<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;
use App\Models\Twitter;


class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function imageProcess($text){
        \Log::info("image running...");
            $img = imagecreatefromjpeg(public_path('/img/test_png.jpeg'));
            
            $white = imagecolorallocate($img, 255, 255, 255);
            $txt_input =$text;
            
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
            $save=public_path('/img/new23.png'); 
            imagepng($img,$save,0,NULL); 
            imagedestroy($img);
            return $save;
    }
    public function handle()
    {

        // try {
        $link = $this->imageProcess($this->data->post->text);
        $id = $this->data->bussness_id;
        
        $endpoint = "https://graph.facebook.com/v5.0/$id/media";
        $accessToken = $this->data->fb_token;
        // $accessToken =  'EAAF67SZB7BjoBAMrEm63kRSgzh5QSigHhD3DDxA5m1yTQoC4VagxaZBoMuoDCXBYAeP8thwgtzbxIsQm80DjZCtweouScZCSF62voCGg2eb0jjPFFfd6oR58xnYIbaA0fYzl7WUYe74QhJQgslFP2LHNZC87VZACFVzEAZAGnz65qqP67YUiXcWGag7ffeKKmZBmIahBZBdowVBuigvhVC8m0tU368lEuqfOZCtJfgUBc8CgZDZD';
        $params = array( // POST
            'image_url' => 'https://cdn.forehand.se/uploads/1638203773.png',
            'caption' => "testing ..",
            'access_token' => $accessToken
        );
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

        $publishImageEndpoint = "https://graph.facebook.com/v5.0/$id/media_publish";
        $params = array(
            'creation_id' =>  $response->id,
            'access_token' => $accessToken
        );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $publishImageEndpoint );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );
		curl_close( $ch );

        Twitter::where('id', $this->data->post->id)->update(['is_published'=>"Complited"]);

        
        // } catch (\Throwable $th) {
          
        //     \Log::info(["he"=>"fail"]);
        //         Twitter::where('id', $this->data->post->id)->update(['is_published'=>"Pending"]);
        // }
        // return 1;
         
        //  \Log::info($response);
        
    }
}
