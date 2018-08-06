<?php

namespace App\Http\Controllers\Admin;

// Framework
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\Admin\Category\UpdateCategoriesRequest;

class CategoryController extends Controller
{
    /**
     * Display the PasswordBag Home Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('admin');
    }

    /**
     * Returns all the Categories.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $categories = Category::select('id', 'name', 'position')->orderBy('position')->get();
        
        return response()->json($categories);
    }

    /**
     * Update all the Categories.
     * 
     * @param UpdateCategoriesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAll(UpdateCategoriesRequest $request)
    {
       $categories = $request->all();

       $categoriesToSave = [];

       foreach($categories['categories'] as $category){

           if(array_key_exists('id', $category)){

                $id = $category['id'];

                $categoriesToSave[] =  $id;

                unset($category['id']);
               
                Category::where('id', $id)->update($category);
           }else{
                $newCategory = Category::create($category);

                $categoriesToSave[] = $newCategory->id;
           }
       }

       $categoriesToDelete = Category::whereNotIn('id', $categoriesToSave)->get();

       if($categoriesToDelete){
           
           foreach ($categoriesToDelete as $category){
               
               if( $accountGroups = $category->has('accountGroups')){
                   
                   foreach ($category->accountGroups as $accountGroup){
                       $accountGroup->category()->dissociate()->save();
                   }
                   
               }
               
           }
           
       }
        
        Category::whereNotIn('id', $categoriesToSave)->delete();

       $categories = Category::select('id', 'name', 'position')->orderBy('position')->get();

       return response()->json($categories);
    }
}
