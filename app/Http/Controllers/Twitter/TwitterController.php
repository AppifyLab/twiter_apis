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
        return $this->featchTweetes($single_twitter_users);
         return $single_twitter_users;

    }

    public function featchTweetes($single_twitter_users){
        try {
            $alldata = $this->twitterService->getTweetsForInitilization($single_twitter_users,100);
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
