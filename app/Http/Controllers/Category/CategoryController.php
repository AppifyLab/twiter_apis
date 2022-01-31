<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
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
        return $this->categoryService->addCategory($data);
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
            'first_name'   => 'required|string|max:199',
            'last_name'   => 'required|string|max:199',
            'email' => 'required|string|max:199|unique:users,email',
            'username' => 'required|string|max:199|unique:users,username|regex:/^\S*$/u',
            'password' => 'required|min:6',
            'gender' => 'required|in:MALE,FEMALE,OTHER',
        ],[
            'first_name.required' =>"First Name is required!",
            'last_name.required' =>"Last Name is required!",
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
            'first_name'   => 'required|string|max:199',
            'last_name'   => 'required|string|max:199',
            'email' => 'required|string|max:199|unique:users,email,'. $id,
            'username' => 'required|string|max:199|regex:/^\S*$/u|unique:users,username,'. $id,
            'gender' => 'required|in:MALE,FEMALE,OTHER',
        ],[
            'first_name.required' =>"First Name is required!",
            'last_name.required' =>"Last Name is required!",
            'username.unique' =>"Author must be unique!",
            'username.regex' =>"Author can not contain blank spaces!",
            'email.required' =>"Email is required!",
            'email.unique' =>"Email must be unique!",
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
