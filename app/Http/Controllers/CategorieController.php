<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return Categorie::select('id', 'name', 'parent_id')->get() ;
        }catch(Exception $e){
            return response()->json([
                'message' => 'Getting Categories Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' =>'required',
                'parent_id' => 'nullable|integer'
            ]);
            $categorie = Categorie::create($request->all());
            return response()->json([
               'message' => 'Category Created Successfully',
                'category' => $categorie
            ], 201);
        }catch(Exception $e){
            return response()->json([
               'message' => 'Creating Category Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function update_categorie(Request $request)
    {
        try{

            $validated = $request->validate([
                'id' =>'required|integer',
                'name' => 'sometimes|string|max:255',
                'parent_id' => 'sometimes|exists:categories,id'
            ]);
            $category = Categorie::find($validated['id']);
            
            
            if (!$category) {
                return response()->json([
                    'message' => 'not exist'
                ], 404);
            }
            $category->update($validated);
            
            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category
            ]);
        }catch(Exception $e){
            return response()->json([
               'message' => 'Updating Category Failed',
                'error' => $e->getMessage()
            ], 500);
        }  
    }


    public function delete_categorie(Request $request)
{
    try {
        // تحقق من صحة ID المرسل
        $validated = $request->validate([
            'id' => 'required|integer|exists:categories,id'
        ]);

        
        $category = Categorie::find($validated['id']);

        
        if (!$category) {
            return response()->json([
                'message' => 'not exist'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Categorie deleted successfully'
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'message' => 'Failed to delete Categorie',
            'error' => $e->getMessage()
        ], 500);
    }
}



    public function main_categories( Categorie $categorie)
    {
        try{
            return Categorie::whereNull('parent_id')->get();
            
        }catch(Exception $e){
            return response()->json([
               'message' => 'Getting Categorys Failed',
                'error' => $e->getMessage()
            ], 500);
        }   
    }

    public function sous_categories( Categorie $categorie)
    {
        try{
            return Categorie::whereNotNull('parent_id')->get();
            
        }catch(Exception $e){
            return response()->json([
               'message' => 'Getting Categorys Failed',
                'error' => $e->getMessage()
            ], 500);
        }   
    }
}
