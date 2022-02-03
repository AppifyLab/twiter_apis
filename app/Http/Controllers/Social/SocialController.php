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
  
    public function postInstagramForFirstTimeActivate(){
        $id = Auth::user()->id;
        return $this->socialService->postInstagramForFirstTimeActivate($id);
    }

}
