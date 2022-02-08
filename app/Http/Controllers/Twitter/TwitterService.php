<?php

namespace App\Http\Controllers\Twitter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class TwitterService
{
    private $twitterQuery;
    public function __construct(TwitterQuery $twitterQuery)
    {
        $this->twitterQuery = $twitterQuery;
    }
    //================================ Twitter-Start ========================================
    public function addTwitterUser($data){
        $data['user_id'] =  Auth::id();
        return $this->twitterQuery->addTwitterUser($data);
    }
    public function editTwitterUser($data){
        $data['user_id'] =  Auth::id();
        return $this->twitterQuery->editTwitterUser($data);
    }
    public function updateTwites($data){
      return $this->twitterQuery->updateTwites($data);
  }
    
    public function deleteTwitterUser($data){
        return $this->twitterQuery->deleteTwitterUser($data);
    }
    public function getAlltwitterData($data){
      $data['user_id'] =  Auth::user()->id;
        return $this->twitterQuery->getAlltwitterData($data);
    }
    public function getAllTwitterPostList($data){
      $data['user_id'] = Auth::user()->id;
        return $this->twitterQuery->getAllTwitterPostList($data);
    }
    public function insertTwitters($data){
        return $this->twitterQuery->insertTwitters($data);
    }
    public function getTwitterUser(){
      return $this->twitterQuery->getTwitterUser();
    }


    public function  getTweetsForInitilization($single_twitter_users, $limit){
      $bearer_token = env('TWITTER_TOKEN');
      $user_name = $single_twitter_users->username;
      $user_id= $single_twitter_users->user_id;
      $client = new \GuzzleHttp\Client();
      $twitter_user = (string) $client->get('https://api.twitter.com/2/users/by/username/'.$user_name,
      ['headers' => 
          [
              'Authorization' => "Bearer $bearer_token"
          ]
      ]
      )->getBody();
      $user_data =json_decode($twitter_user);
      $url = 'https://api.twitter.com/2/users/'.$user_data->data->id.'/tweets?tweet.fields=public_metrics,attachments,entities,created_at&max_results='. $limit;
      $tdate = Carbon::now();
      $last_updatetime = $tdate->format('Y-m-d\TH:i:s\Z');
      $this->updateTwites(['id'=>$single_twitter_users['id'],'twitter_user_id'=>$user_data->data->id,'last_updatetime'=>$last_updatetime]);

      $tweets = (string) $client->get($url,
      ['headers' => 
          [
              'Authorization' => "Bearer $bearer_token"
          ]
      ]
      )->getBody();
      $alldata =json_decode($tweets);
      return $alldata;
    }
    //================================ Twitter-End ========================================


}
