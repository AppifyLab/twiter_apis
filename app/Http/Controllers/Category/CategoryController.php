<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\FetchingPost;
use Carbon\Carbon;
use App\Common\Customhelper;
use App\Http\Controllers\Social\SocialController;
class CategoryController extends Controller
{

    private $categoryService;
    private $socialService;
    private $customHelper;
    public function __construct(CategoryService $categoryService,SocialController $socialService ,Customhelper $customHelper)
    {
        $this->categoryService = $categoryService;
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
    public function editAdminUser(Request $request){
        $data = $request->all();
        return $this->categoryService->editAdminUser($data);
   }
   public function getstath(Request $request){
    // $data = $request->all();
    return $this->categoryService->getstath();
}
   
   
   public function editAdminPassword(Request $request){
        $data = $request->all();
        return $this->categoryService->updatePassword($data);
    }
   

    //================================ Category-Start ========================================
    public function addCategory(Request $request){
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

        $single_twitter_users = $this->categoryService->addCategory($data);
          $this->featchTweetes($single_twitter_users);
         return $single_twitter_users;

    }

    public function featchTweetes($single_twitter_users){
        try {
            $limit = 25;
            $user_name = $single_twitter_users->username;
            $user_id= $single_twitter_users->user_id;
            $client2 = new \GuzzleHttp\Client();
            $request1 = (string) $client2->get('https://api.twitter.com/2/users/by/username/'.$user_name,
            ['headers' => 
                [
                    'Authorization' => "Bearer AAAAAAAAAAAAAAAAAAAAAOWNYgEAAAAAD1NQJpQfL98Al2lJAYWojnmeOJY%3D9tOPIa1RUfdwVOfrEqSUw0Hmr9v6RWxyES06AcwAY3dXvkUdM6"
                ]
            ]
            )->getBody();
            $user_data =json_decode($request1);
            $token = 100;
            $client2 = new \GuzzleHttp\Client();
            $url = 'https://api.twitter.com/2/users/'.$user_data->data->id.'/tweets?tweet.fields=public_metrics,attachments,entities,created_at&max_results='. $limit;
            $tdate = Carbon::now();
            $last_updatetime = $tdate->format('Y-m-d\TH:i:s\Z');
            $this->categoryService->updateTwites(['id'=>$single_twitter_users['id'],'twitter_user_id'=>$user_data->data->id,'last_updatetime'=>$last_updatetime]);

            $request2 = (string) $client2->get($url,
            ['headers' => 
                [
                    'Authorization' => "Bearer AAAAAAAAAAAAAAAAAAAAAOWNYgEAAAAAD1NQJpQfL98Al2lJAYWojnmeOJY%3D9tOPIa1RUfdwVOfrEqSUw0Hmr9v6RWxyES06AcwAY3dXvkUdM6"
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
    public  function sortArrayByName($inputArr) {

        $n = sizeof($inputArr);
        for ($i = 1; $i < $n; $i++) {
            // Choosing the first element in our unsorted subarray
            $current = $inputArr[$i];
            $like = $inputArr[$i]['like'];
            // return 1;
            // The last element of our sorted subarray
            $j = $i-1;

            while (($j > -1) && isset($inputArr[$j]['like']) && ($like > $inputArr[$j]['like'])) {
                $inputArr[$j+1] = $inputArr[$j];
                $j--;
            }
            $inputArr[$j+1] = $current;
        }
        return $inputArr;
        
    }
    public function editCategory(Request $request){
        $data = $request->all();
        $id = $data['cat_id'] ?? 0;
        $validator = Validator::make($data,[
            'username'   => "required|string|unique:categories,username,$id",
        ],[
            'username.required' => "Category name is required.",
            'username.unique' => "Category name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->editCategory($data);
    }

    public function deleteCategory(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'cat_id'   => "required|exists:categories,id",
        ],[
            'cat_id.required' => "Category name is required.",
            'cat_id.exists' => "Category doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deleteCategory($data);
    }

    public function getAlltwitterData(Request $request){
        $data = $request->all();
        return $this->categoryService->getAlltwitterData($data);
    }
    public function getAllTwitterPostList(Request $request){
        $data = $request->all();
        return $this->categoryService->getAllTwitterPostList($data);
    }

    
    //================================ Category-End ========================================


    //================================ Admin-Start ========================================
    public function createAdmin(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'email' => 'required|string|max:199|unique:users,email',
            'username' => 'required|string|max:199|unique:users,username',
            'password' => 'required|min:6',
        ],[
            'username.unique' =>"User must be unique!",
            'username.regex' =>"User can not contain blank spaces!",
            'email.unique' =>"Email must be unique!",
            'password.required' =>"Password is required!",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->createAdmin($data);
    }
    public function editAdmin(Request $request){
        $data = $request->all();
        $id = $data['uid'];
        $validator = Validator::make($data,[
            'uid'   => 'required|exists:users,id',
            'email' => 'required|string|max:199|unique:users,email,'. $id,
            'username' => 'required|string|max:199|unique:users,username,'. $id,
        ],[
            'username.unique' =>"Author must be unique!",
            'username.regex' =>"Author can not contain blank spaces!",
            'email.required' =>"Email is required!",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->editAdmin($data);
    }

    public function getAllAdmins(Request $request){
        $data = $request->all();
        return $this->categoryService->getAllAdmins($data);
    }

    public function deleteAdmin(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'uid'   => "required|exists:users,id",
        ],[
            'uid.required' => "User is required.",
            'uid.exists' => "User doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deleteAdmin($data);
    }
    //================================ Admin-End ========================================


}
