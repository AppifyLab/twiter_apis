<?php

namespace App\Http\Controllers\Twitter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\FetchingPost;
use Carbon\Carbon;
use App\Common\Customhelper;
use App\Http\Controllers\Social\SocialController;
class TwitterController extends Controller
{

    private $twitterService;
    private $socialService;
    private $customHelper;
    public function __construct(TwitterService $twitterService,SocialController $socialService ,Customhelper $customHelper)
    {
        $this->twitterService = $twitterService;
        $this->socialService = $socialService;
        $this->customHelper = $customHelper;
    }
    public function test(){
        $tdate = Carbon::now();

        $date = $tdate->format('Y-m-d\TH:i:s\Z');
        // $date = Carbon::createFromFormat('Y-m-d H:i:s', $request->date)->format('d-m-Y');
        $date2 =  date('Y-m-d H:i:s', strtotime('-3 minutes'));
      
        return [$date, $date2];
    }
  
   

    //================================ Twitter-Start ========================================
    public function addTwitterUser(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'username'   => 'required|string|unique:categories,username'
        ],[
            'username.required' => "username name is required.",
            'username.unique' => "username name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }

        $single_twitter_users = $this->twitterService->addTwitterUser($data);
          $this->featchTweetes($single_twitter_users);
         return $single_twitter_users;

    }

    public function featchTweetes($single_twitter_users){
        try {
            $limit = 100;
            $bearer_token = env('TWITTER_TOKEN');
            $user_name = $single_twitter_users->username;
            $user_id= $single_twitter_users->user_id;
            $client2 = new \GuzzleHttp\Client();
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
            $url = 'https://api.twitter.com/2/users/'.$user_data->data->id.'/tweets?tweet.fields=public_metrics,attachments,entities,created_at&max_results='. $limit;
            $tdate = Carbon::now();
            $last_updatetime = $tdate->format('Y-m-d\TH:i:s\Z');
            $this->twitterService->updateTwites(['id'=>$single_twitter_users['id'],'twitter_user_id'=>$user_data->data->id,'last_updatetime'=>$last_updatetime]);

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
            $this->customHelper->insertTweetIntoTheDatabase($data,$single_twitter_users);
            return "sucess";
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message' => "Invalied twitter username!",
            ], 401);
        }
    }
  
    public function editTwitterUser(Request $request){
        $data = $request->all();
        $id = $data['cat_id'] ?? 0;
        $validator = Validator::make($data,[
            'username'   => "required|string|unique:categories,username,$id",
        ],[
            'username.required' => "Twitter name is required.",
            'username.unique' => "Twitter name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->twitterService->editTwitterUser($data);
    }

    public function deleteTwitterUser(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'cat_id'   => "required|exists:categories,id",
        ],[
            'cat_id.required' => "Twitter name is required.",
            'cat_id.exists' => "Twitter doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->twitterService->deleteTwitterUser($data);
    }

    public function getAlltwitterData(Request $request){
        $data = $request->all();
        return $this->twitterService->getAlltwitterData($data);
    }
    public function getAllTwitterPostList(Request $request){
        $data = $request->all();
        return $this->twitterService->getAllTwitterPostList($data);
    }
    public function getTwitterUser(){
        return  $this->twitterService->getTwitterUser();
    }

    
    //================================ Twitter-End ========================================

  


}
