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
    public function handle()
    {

        $endpoint = "https://graph.facebook.com/v5.0/17841403387597803/media";
        $accessToken = 'EAAIwvcvN4CIBAPZCAirq0MnOQCjx5Bw9zo6OZAeZBdQnZAN8W1XG7aFb02HThTfM44uuV494jqxcS2r6RZALFUbvjk8ZCJIAiFzHuKZBRHziyIvhBUXLc0cn3VZAiY029ETJrqRr5zNaUKmNlqHjj5dMeOv9HVzovGFBMKIHjfP2Uy2TPjOCZAzYk';
        // return $image;
        $params = array( // POST
            // 'image_url' => '/Users/appifylab_01/laravel_project/instagramapi/public/img/new23.png',
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

        $publishImageEndpoint = "https://graph.facebook.com/v5.0/17841403387597803/media_publish";
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
 
        //
         Twitter::where('id', $this->data->id)->update(['is_published'=>1]);
        return $response;
    }
}
