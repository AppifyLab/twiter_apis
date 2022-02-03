<?php

namespace App\Http\Controllers\Twitter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



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
    //================================ Twitter-End ========================================


}
