<?php

namespace App\Http\Controllers\Social;
class SocialService
{
    private $socialQuery;
    public function __construct(SocialQuery $socialQuery)
    {
        $this->socialQuery = $socialQuery;
    }
    public function updateUser($token, $id){
        return $this->socialQuery->updateUser($token, $id);
    }
    public function singleTwitterUser(){
        return $this->socialQuery->singleTwitterUser();
    }
 
    public function postInstagramForFirstTimeActivate($id){

        return $this->socialQuery->postInstagramForFirstTimeActivate($id);
    }
    public function insertIntoQueueForPostInstagram(){
        return $this->socialQuery->insertIntoQueueForPostInstagram();
    }
   
    
    public function updateTwitesStatus($ids,$status){
        return $this->socialQuery->updateTwitesStatus($ids,$status);
    }
    
    
    public function getUser(){
        return $this->socialQuery->getUser();
    }
    public function updateUserFirstCall(){
        return $this->socialQuery->updateUserFirstCall();
    }
    
    
    
     public function updateTwiterPost($id){
        return $this->socialQuery->updateTwiterPost($id);
    }
    
    

}
