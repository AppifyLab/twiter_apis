<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Models\Information;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CategoryQuery
{
    public function  getstath()
    {
        $cat = Category::count('id');
        $subcat = Subcategory::count('id');
        $subsubcat = SubSubcategory::count('id');
        $items = Information::count('id');
        return [
            "cat"=>$cat,
            "subcat"=>$subcat,
            "subsubcat"=>$subsubcat,
            "items"=>$items,
        ];
        // return User::where('id','!=',$id)->where('email',$email)->first();
    }

    public function checkUser($id,$email)
    {
        return User::where('id','!=',$id)->where('email',$email)->first();
    }
    
    public function editAdminUser($key, $value, $user){
        return User::where($key, $value)->update($user);
    }
    public function getSingleUser($key, $value){
        return User::where($key, $value)->first();
      }
    //================================ Category-Start ========================================
    public function addCategory($data){
        return Category::create($data);
    }
    public function editCategory($data){
        $id = $data["cat_id"] ?? 0;
        unset($data["cat_id"]);
        return Category::where('id', $id)->update($data);
    }
    public function deleteCategory($data){
        $id = $data["cat_id"] ?? 0;
        return Category::where('id', $id)->delete();
    }
    public function getAllCategories($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        return Category::when($str, function($q) use($str){
            $q->where('cat_name', 'like', $str);
        })->orderByDesc('id')->paginate(10);
    }

    //================================ Category-End ========================================

    //================================ Subcategory-Start ========================================
    public function addSubcategory($data){
        $subcat = Subcategory::create($data);
        if($subcat){
            return Subcategory::where('id', $subcat->id)->with('category')->first();
        }
    }

    public function getCategories(){
        return Category::select('id','cat_name')->get();
    }
    public function getAllSubcategories($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        return Subcategory::when($str, function($q) use($str){
            $q->where('subcat_name', 'like', $str);
            $q->orWhereHas('category', function (Builder $query) use($str) {
                $query->where('cat_name', 'like', $str);
            });
        })->with('category:id,cat_name')->orderByDesc('id')->paginate(10);
    }
    public function editSubcategory($data){
        $id = $data["subcat_id"] ?? 0;
        unset($data["subcat_id"]);
        $subcat = Subcategory::where('id', $id)->update($data);
        if($subcat){
            return Subcategory::where('id', $id)->with('category')->first();
        }
    }
    public function deletesubcategory($data){
        $id = $data["subcat_id"] ?? 0;
        return Subcategory::where('id', $id)->delete();
    }

    //================================ Subcategory-End ========================================

    //================================ Subcategory-Start ========================================
    public function addSubsubcategory($data){

        $subcat = SubSubcategory::create($data);
        if($subcat){
            return SubSubcategory::where('id', $subcat->id)->with('category')->with('subcategory')->first();
        }

    }
    public function getSubcategories($data){
        $cats = $data['cat_id'] ?? 0;
        $ids = explode (",", $cats);

        return Subcategory::when($ids, function($q) use($ids){
            $q->whereIn('category_id', $ids);
          })->select('id','subcat_name')->get();
    }
    public function getSubsubcategories($data){
        $cats = $data['subcat_id'] ?? 0;
        $ids = explode (",", $cats);
        return SubSubcategory::when($ids, function($q) use($ids){
            $q->whereIn('subcategory_id', $ids);
          })->select('id','sub_subcat_name')->get();
    }
    public function getAllSubsubcategories($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        return SubSubcategory::when($str, function($q) use($str){
            $q->where('sub_subcat_name', 'like', $str);
            $q->orWhereHas('category', function (Builder $query) use($str) {
                $query->where('cat_name', 'like', $str);
            });
            $q->orWhereHas('subcategory', function (Builder $query) use($str) {
                $query->where('subcat_name', 'like', $str);
            });
        })->with('category:id,cat_name')->with('subcategory:id,subcat_name')->orderByDesc('id')->paginate(10);
    }
    public function editSubsubcategory($data){
        $id = $data["sub_subcat_id"] ?? 0;
        unset($data["sub_subcat_id"]);
        $subcat = SubSubcategory::where('id', $id)->update($data);
        if($subcat){
            return SubSubcategory::where('id', $id)->with('category')->with('subcategory')->first();
        }
    }

    public function deleteSubsubcategory($data){
        $id = $data["sub_subcat_id"] ?? 0;
        return SubSubcategory::where('id', $id)->delete();
    }


    //================================ Subcategory-End ========================================


    //================================ Information-Start ========================================

    public function addInformation($data){
        $info = Information::create($data);
        $info->categories()->attach($data['category_id']);
        $info->subcategories()->attach($data['subcategory_id']);
        $info->subSubcategories()->attach($data['subSubcategory_id']);
        if($info){
            return Information::where('id', $info->id)->with('categories:id,cat_name')->with('subcategories:id,subcat_name')->with('subSubcategories:id,sub_subcat_name')->first();
        }
        return $info;
    }

    public function editInformation($data){
        $id = $data['info_id'];
        $category_id =$data['category_id'] ?? null;
        $subcategory_id =$data['subcategory_id'] ?? null;
        $sub_subcategory_id =$data['subSubcategory_id'] ?? null;

        unset($data['info_id'],$data['category_id'],$data['subcategory_id'],$data['subSubcategory_id']);

        $info = Information::where('id', $id)->first();
        $info->update($data);

        if($category_id){
            $info->categories()->syncWithPivotValues($category_id, ["information_id" => $info->id]);
        }
        if($subcategory_id){
            $info->subcategories()->syncWithPivotValues($subcategory_id, ["information_id" => $info->id]);
        }
        if($sub_subcategory_id){
            $info->subSubcategories()->syncWithPivotValues($sub_subcategory_id, ["information_id" => $info->id]);
        }

        if($info){
            return Information::where('id', $info->id)->with('categories:id,cat_name')->with('subcategories:id,subcat_name')->with('subSubcategories:id,sub_subcat_name')->first();
        }
        return $info;
    }

    public function deleteInformation($data){
        $id = $data["info_id"] ?? 0;
        return Information::where('id', $id)->delete();
    }

    public function getAllInfo($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        return Information::when($str, function($q) use($str){
            $q->whereRaw("concat(
                action,
                ' ', challenge,
                ' ', address,
                ' ', phone,
                ' ', food_type,
                ' ', description,
                ' ', website,
                ' ', star_rating,
                ' ', google_ratings
                ) like '$str' ");
            $q->orWhereHas('categories', function (Builder $query) use($str) {
                $query->where('cat_name', 'like', $str);
            });
            $q->orWhereHas('subcategories', function (Builder $query) use($str) {
                $query->where('subcat_name', 'like', $str);
            });
            $q->orWhereHas('subSubcategories', function (Builder $query) use($str) {
                $query->where('sub_subcat_name', 'like', $str);
            });
        })->with('categories:id,cat_name')->with('subcategories:id,subcat_name')->with('subSubcategories:id,sub_subcat_name')->orderByDesc('id')->paginate(10);
    }

    //================================ Information-End ========================================


    //================================ Admin-start ========================================
    public function createAdmin($data){
        return User::create($data);
    }
    public function editAdmin($data){
        $uid = $data['uid'] ?? 0 ;
        unset($data['uid']);
        return User::where('id', $uid)->update($data);
    }
    public function getAllAdmins($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        return User::when($str, function($q) use($str){
            $q->whereRaw("concat(
                first_name,
                ' ', last_name,
                ' ', email,
                ' ', username,
                ' ', gender
                ) like '$str' ");
        })->where('role', '!=', 'SUPER_ADMIN')->orderByDesc('id')->paginate(10);
    }
    public function deleteAdmin($data){
        $id = $data["uid"] ?? 0;
        return User::where('id', $id)->delete();
    }
    //================================ Admin-End ========================================
}
