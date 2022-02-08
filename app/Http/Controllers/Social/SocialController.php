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
use App\Common\Customhelper;
use Illuminate\Support\Facades\Auth;


class SocialController extends Controller
{

    private $socialService;
    private $customHelper;

    public function __construct(SocialService $socialService,Customhelper $customHelper)
    {
        $this->socialService = $socialService;
        $this->customHelper = $customHelper;
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
    }
  
    public function postInstagramForFirstTimeActivate(){
        $id = Auth::user()->id;
        return $this->socialService->postInstagramForFirstTimeActivate($id);
    }


      // new methods

      public function getFbPage(){
        $token=  Auth::user()->fb_token;
        $fb = new Facebook();
        $response = $fb->get('/me/accounts', $token);
        $pages = $response->getGraphEdge()->asArray();
        return $pages ;
    }

    public function connectBussnessId(Request $request){

        $user = Auth::user();
        if($user->bussness_id){
            return response()->json([
                'message' => "You are already connected!",
            ], 401);

        }
        $data = $request->all();
        $instagram =  $this->customHelper->instagramAccountId($data['id'], $data['category_list'][0]['id'],$data['access_token']);

        return $this->socialService->checkAndUpdateInstgramBussnessId($instagram,$user->id);


    }
   


}
