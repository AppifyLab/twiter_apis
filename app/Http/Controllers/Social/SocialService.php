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
    
     public function updateTwiterPost($id){
        return $this->socialQuery->updateTwiterPost($id);
    }



    // new methods
    public function checkAndUpdateInstgramBussnessId($data,$id){
        if(!isset($data->instagram_business_account)){
            return response()->json([
                'message' => "Please connect your page with your instagram account!",
            ], 401);
        }
        $ob = [
            'id'=>$id,
            'bussness_id'=>$data->instagram_business_account->id
        ];
        return $this->socialQuery->updateCommonUser($ob);
    }
    

}
