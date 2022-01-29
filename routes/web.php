<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// use Illuminate\Http\Request;
// use Twitter;
// use File;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/userTimeline', function(){


    // $client2 = new \GuzzleHttp\Client();
    // $request2 = (string) $client2->post('https://api.twitter.com/1.1/search/tweets.json?q=&result_type=popular', ['form_params' => $ob])->getBody();
    // return $request2;



    $data = Twitter::getUserTimeline(['screen_name' => '@kamran_not_me','tweet_mode'=>'extended','count' => 4,'response_format' => 'json']);
    $data =json_decode( $data);
    return $data;
     if(isset($data[0]) && isset($data[0]->entities) && isset($data[0]->entities->urls[0]) && isset($data[0]->entities->urls[0]->url)){

         $data[0]->full_text = str_replace( $data[0]->entities->urls[0]->url, '', $data[0]->full_text );
     }
  
   return $data[0];

    return ['data'=>$data];
});
// EAAIwvcvN4CIBAL8ZBmulZAF9ZBEPFaxuwBtOAEQhlJEr2pHcRljzcPy46GcF9THB56nEQsJ96KtQU9pbTviKELl1V75TfpEzFyWZBqJGSh6jtrah1jfb3NinLCVxEqZAZBdzGeIXJlKGHeTXucWpqXzMwPWWSHk6hrDdZAEWoRxfJivVXZBXyoQYxyhlQY24uHeyguLOK0n9tay7KZBB25DGnhCKv46ZBq7ItDv05b4HMrZAgZDZD
Route::get('/auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/twitterUserTimeLine', function () {
    $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);
    // return view('twitter',compact('data'));

    return Socialite::driver('facebook')->redirect();
});
// Route::get('twitterUserTimeLine', 'TwitterController@twitterUserTimeLine');
Route::get('/callback-url', function () {
    $user = Socialite::driver('facebook')->user();
    // return $user;
    return $user->token;
});
Route::get('/{all?}', function () {
    return view('welcome');
})->where(['all' => '.*']);
