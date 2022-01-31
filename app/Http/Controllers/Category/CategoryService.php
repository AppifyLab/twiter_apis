<?php

namespace App\Http\Controllers\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class CategoryService
{
    private $categoryQuery;
    public function __construct(CategoryQuery $categoryQuery)
    {
        $this->categoryQuery = $categoryQuery;
    }

    public function editAdminUser($data){

       $auth = Auth::user();
       if(!$auth || $auth['id'] !=$data['id']){
           return response()->json([
               'message' => "Your are not authorised User!.",
           ],401);
         }
         $user =  $this->categoryQuery->checkUser($auth['id'], $data['email']);
   
         if($user){
            return response()->json([
                'message' => "Email must be unique!.",
            ],401);
         }
   
         return $this->categoryQuery->editAdminUser('id',$data['id'], [
           "first_name"=> $data['first_name'],
           "last_name"=> $data['last_name'],
           "username"=> $data['username'],
           "email"=>$data['email']
         ]);

   }
   public function editAdminPassword($data){
    $auth = Auth::user();
    if(!$auth || $auth['id'] !=$data['id']){
        return response()->json([
            'message' => "Your are not authorised User!.",
        ],401);
      }
      $userInfo  =  $this->categoryQuery->getSingleUser('id',$data['id']);

      $check = Hash::check($userInfo['password'], $data['currentPassword']);
      if (!$check) {
        return response()->json([
            'message' => "Current password doesn`t match!",
        ],401);
      }
      return $this->categoryQuery->editAdminUser('id',$data['id'], [
        "password"=> Hash::make($data['newPassword']),
      ]);
        return $this->categoryQuery->editAdminPassword($data);
    }

    public function updatePassword($data)
    {
        if( $data['id'] != Auth::id()){
            return response()->json([
              'message' => "You are not Authenticate Admin!",
            ], 401);
         }
         
         $admin = $this->categoryQuery->getSingleUser('id', $data['id']);
        //  \Log::info($admin);
        //  return $admin['password'] ;
         
         if($admin){
             
            $checkOld =Hash::check($data['currentPassword'], $admin->password );
            $checkNew =Hash::check($data['newPassword'], $admin->password );
            
            if(!$checkOld){
              return response()->json([
                'message' => "Password does not match to our records!",
              ], 401);
            }
            if($checkNew){
              return response()->json([
                'updated' => "Password is already been taken!",
              ], 401);
            }
            
         }else{
            
                return response()->json([
                  'message' => "Password does not exists !",
                ], 401);
             
         }
        
        return $this->categoryQuery->editAdminUser('id',$data['id'], [
            "password"=>Hash::make($data['newPassword'])
          ]);
      
    }
    
    public function getstath(){
        return $this->categoryQuery->getstath();
    }
    //================================ Category-Start ========================================
    public function addCategory($data){
        return $this->categoryQuery->addCategory($data);
    }
    public function editCategory($data){
        return $this->categoryQuery->editCategory($data);
    }
    public function deleteCategory($data){
        return $this->categoryQuery->deleteCategory($data);
    }
    public function getAlltwitterData($data){
        return $this->categoryQuery->getAlltwitterData($data);
    }
    public function getAllTwitterPostList($data){
        return $this->categoryQuery->getAllTwitterPostList($data);
    }

    

    //================================ Category-End ========================================

    //================================ Subcategory-Start ========================================
    public function addSubcategory($data){
        return $this->categoryQuery->addSubcategory($data);
    }
    public function getCategories(){
        return $this->categoryQuery->getCategories();
    }
    public function getAllSubcategories($data){
        return $this->categoryQuery->getAllSubcategories($data);
    }
    public function editSubcategory($data){
        return $this->categoryQuery->editSubcategory($data);
    }
    public function deletesubcategory($data){
        return $this->categoryQuery->deletesubcategory($data);
    }
    //================================ Subcategory-End ========================================

    //================================ Sub-Subcategory-Start ========================================
    public function addSubsubcategory($data){
        return $this->categoryQuery->addSubsubcategory($data);
    }
    public function getSubcategories($data){
        return $this->categoryQuery->getSubcategories($data);
    }
    public function getSubsubcategories($data){
        return $this->categoryQuery->getSubsubcategories($data);
    }
    public function getAllSubsubcategories($data){
        return $this->categoryQuery->getAllSubsubcategories($data);
    }
    public function editSubsubcategory($data){
        return $this->categoryQuery->editSubsubcategory($data);
    }
    public function deleteSubsubcategory($data){
        return $this->categoryQuery->deleteSubsubcategory($data);
    }

    //================================ Sub-Subcategory-End ========================================


    //================================ Information-Statt ========================================

    public function addInformation($data){
        return $this->categoryQuery->addInformation($data);
    }
    public function editInformation($data){
        return $this->categoryQuery->editInformation($data);
    }
    public function getAllInfo($data){
        return $this->categoryQuery->getAllInfo($data);
    }
    public function deleteInformation($data){
        return $this->categoryQuery->deleteInformation($data);
    }
    //================================ Information-End ========================================


    //================================ Admin-Start ========================================
    public function createAdmin($data){
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'ADMIN';
        $data['status'] = 'ACTIVE';
        return $this->categoryQuery->createAdmin($data);
    }
    public function editAdmin($data){
        if(isset($data['password']) && strlen($data['password']) <6){
            return response()->json([
                'message' => "Password must be at least 6 characters long!",
            ],401);
        }else if(isset($data['password']) && strlen($data['password']) >5){
            $data['password'] = Hash::make($data['password']);
        }

        return $this->categoryQuery->editAdmin($data);
    }
    public function getAllAdmins($data){
        return $this->categoryQuery->getAllAdmins($data);
    }
    public function deleteAdmin($data){
        return $this->categoryQuery->deleteAdmin($data);
    }
    //================================ Admin-End ========================================

}
