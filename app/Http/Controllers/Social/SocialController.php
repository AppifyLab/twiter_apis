<?php

namespace App\Http\Controllers\Social;

use Facebook\Facebook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Twitter;
use Carbon\Carbon;
use App\Jobs\ProcessPodcast;
use App\Jobs\FetchingPost;
use Illuminate\Support\Facades\Auth;


class SocialController extends Controller
{

    private $socialService;

    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

    public function login(){
        return Socialite::driver('facebook')
        ->scopes([
            'public_profile',
            'instagram_basic',
            'pages_show_list',

            'instagram_manage_insights',
            'instagram_manage_comments',
            'ads_management',
            'business_management',
            'instagram_content_publish',
            'pages_read_engagement'])->redirect();
    }
    public function facebookredirect(Request $request){
        $user = Socialite::driver('facebook')->user();

        $id =  Auth::user()->id;
        
        $this->socialService->updateUser($user->token,$id);
        return redirect('/twitter');
        
        
       return $this->getFbPage($user->token);

    }
    public function getFbPage($token){

        // $token = $this->login();
        // // return $token;
        // return ['token'=>$token ];

        $fb = new Facebook();
        // $token = 'EAAIwvcvN4CIBALXv74F8uNyr1aJzOOQFMUWCZCVanMyLa7ZCa6zfKburjSanWmqSQNU33briPRp0Nakn9ksUKw4y7GOEZA217ZBeR3jZCaGqmFPYfYbWnUmez2HFK5P6ezo8vVofbKd5zc2ya14ZADQFn5i35QqqqDZAnYajvwyZBC7qNlRjOQDSn1yhr04p8bAa3Fyt4PTIfHqmeoCgC4hxwbHtcMkqpihRWQGWjDgx2AZDZD';

        $response = $fb->get('/me/accounts', $token);
        $pages = $response->getGraphEdge()->asArray();
        
        // return $pages[0];
        $pageId = $pages[0]['id']?$pages[0]['id']:0;

        $catId =0;
        if(isset($pages[0]['category_list']) && isset($pages[0]['category_list'][0]) && isset($pages[0]['category_list'][0]['id'])){
            $catId = $pages[0]['category_list'][0]['id'];
        }
        $pageToken = 0;
        if(isset($pages[0]['access_token'])){
            $pageToken = $pages[0]['access_token'];
        }
       
       

       return $this->instagramAccountId($pageId ,$catId,$pageToken);

        // $page_id = 414955355197373;
        // $pageToken = 'EAAF67SZB7BjoBAJpMZAaLVmZBBSsOa96ezXEItRTTWrh1QgFIJ8FrztSC3OK09cuPIPdU7CJh5u8PZB6l90OPZAAPL4RZB2GanTkl4pybecze71ysyBhBQcLhuC47lnpQuL42hrTFzFh69MQsERrpfbwVMp07RIHB0hVLt1onPLWOe5QwhCy4ZC';
        // $post = $fb->post('/' . $page_id . '/photos', ['message' => 'posting an image http://widget.forehand.se/knocouttv/dist/?trId=363&socialId=18', 'url' => 'https://cdn.forehand.se/uploads/1638203773.png', ], $pageToken);

        // $post = $post->getGraphNode()->asArray();
        // return $post;


    }
  
   
    public function instagramAccountId($pageId ,$catId, $token){

        $instagramAccountEndpoint = "https://graph.facebook.com/v5.0/".$pageId;
        $igParams = array(
            'fields' => 'instagram_business_account',
            'access_token' => $token
        );

        // add params to endpoint
        $instagramAccountEndpoint .= '?' . http_build_query( $igParams );

        // setup curl
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $instagramAccountEndpoint );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        // make call and get response
        $response = curl_exec( $ch );
        curl_close( $ch );

        $response = json_decode($response);
        $inista_id  = 0;
        if(isset($response->instagram_business_account) && isset($response->instagram_business_account->id)){
            $inista_id =$response->instagram_business_account->id;
        }
        return $this->instagramAccountDetail($pageId,$inista_id,$token);
    }
    public function instagramAccountDetail(){
        $fb = new Facebook();
        $token = 'EAAIwvcvN4CIBAPZCAirq0MnOQCjx5Bw9zo6OZAeZBdQnZAN8W1XG7aFb02HThTfM44uuV494jqxcS2r6RZALFUbvjk8ZCJIAiFzHuKZBRHziyIvhBUXLc0cn3VZAiY029ETJrqRr5zNaUKmNlqHjj5dMeOv9HVzovGFBMKIHjfP2Uy2TPjOCZAzYk';
        $params = "username,id,media_count,biography,website";
        $response = $fb->get(
            "17841403387597803?fields=$params",
            // $inista_id."?fields=$params",
            $token
          )->getGraphUser();
        return $response;
        
    }
  
    public function postInstagramForFirstTimeActivate(){
        $id = Auth::user()->id;
        return $this->socialService->postInstagramForFirstTimeActivate($id);
    }

    public function featchTweetes(){
        try {
            $limit = 5;
            $single_twitter_users = $this->socialService->singleTwitterUser();
            return $single_twitter_users;
            if(!$single_twitter_users){
                return response()->json([
                    'message' => "Please add a twitter user!",
                ], 401);
            }
            
            $user_name = $single_twitter_users->username;
            $client2 = new \GuzzleHttp\Client();
            $bearer_token = env('TWITTER_TOKEN');
            $request1 = (string) $client2->get('https://api.twitter.com/2/users/by/username/'.$user_name,
            ['headers' => 
                [
                    'Authorization' => "Bearer $bearer_token"
                ]
            ]
            )->getBody();
            $user_data =json_decode($request1);
            $token = 100;
            $client2 = new \GuzzleHttp\Client();
            $url = 'https://api.twitter.com/2/users/'.$user_data->data->id.'/tweets?tweet.fields=public_metrics,entities,created_at&max_results='. $limit;
            $request2 = (string) $client2->get($url,
            ['headers' => 
                [
                    'Authorization' => "Bearer $bearer_token"
                ]
            ]
            )->getBody();
            $alldata =json_decode($request2);
            if($alldata->meta->result_count==0) {
                return response()->json([
                    'message' => "No result found!",
                ], 401);
            }
            $data = $alldata->data;
            FetchingPost::dispatch($data);
            return "sucess";
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message' => "Invalied twitter username!",
            ], 401);
        }
    }
    public function fbinfo(Request $request){
        $params = "email,first_name,last_name,age_range,gender";
        $fb = new Facebook();
        $fb->setDefaultAccessToken('EAAF67SZB7BjoBAD7hodaKZC6TGhV5ZCHg9BpH9LZCVRrJHUkXy4ev3T28iRgaFOfNypnsp3GGSMl9MkGRZAsgeXhKJ9telOfp0v1V2oDj4xEf1xZC8CLP6Lx699kbIK9u2sKjvlAmvZCnwwZAqbkeg6dZArVtcZCZBPlrL7GfY9Ry0bvus7yZBUZAHoAo6PddrNGRGDXBbsdYEfDZBf7tvZCZBUCfWi4xuu60Cba9kAeIxGJ6bFnWwZDZD');

        $user = $fb->get('/me?fields='.$params)->getGraphUser();

        return $user;
    }




}
