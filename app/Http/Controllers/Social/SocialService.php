<?php

namespace App\Http\Controllers\Social;
class SocialService
{
    private $socialQuery;
    public function __construct(SocialQuery $socialQuery)
    {
        $this->socialQuery = $socialQuery;
    }
    public function singleTwitterUser(){
        return $this->socialQuery->singleTwitterUser();
    }
    public function getTodaysPost($data,$start,$end){
        return $this->socialQuery->getTodaysPost($data,$start,$end);
    }
     public function updateTwiterPost($id){
        return $this->socialQuery->updateTwiterPost($id);
    }
    
    

}
