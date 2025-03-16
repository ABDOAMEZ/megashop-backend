<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return Products::select('id','seller_id', 'category_id',	'name','description','price','stock_quantity')->get();
        }catch(\Exception $e){  
            return response()->json([
                'message' => "Getting Data Failed",
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'seller_id' => 'required|integer',
                'category_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock_quantity' => 'required|integer',
            ]);
            
            $product_added = Products::create($request->all());
            return response()->json([
                'message' => "product Created Successfully",
                'products' => $product_added
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Creating Data Failed",
                'error' => $e->getMessage()
            ], 500);
        }
    }





    public function update_product(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' =>'required|integer|exists:products,id',
                'seller_id' => 'integer',
                'category_id' => 'integer',
                'name' =>'string|max:255',
                'description' =>'string',
                'price' => 'numeric',
                'stock_quantity' => 'integer',
            ]);

            $product = Products::find($validatedData['id']);

            if(!$product){
                return response()->json([
                   'message' => 'not exist'
                ], 404);
            }

            $product->update($validatedData);

            return response()->json([
                'message' => "product Updated Successfully",
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Updating Data Failed",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function delete_product(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|integer|exists:products,id'
            ]);
    
            
            $product = Products::find($validated['id']);
    
           
            if (!$product) {
                return response()->json([
                    'message' => 'not exist'
                ], 404);
            }
    
            
            $product->delete();
    
            return response()->json([
                'message' => 'product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Deleting Data Failed",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
