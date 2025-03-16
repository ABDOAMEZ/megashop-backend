<?php

namespace App\Http\Controllers;

use App\Models\Product_Images;
use Illuminate\Http\Request;

class ProductImagesController extends Controller
{

    public function index()
    {
        try {
            return Product_Images::select('id', 'product_id', 'image_url', 'is_primary')->get();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to Fetch Images",
                'error' => $e->getMessage()
            ], 500);
        }
    }



    
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'product_id' =>'required|integer',
                'image_url' =>'required|url',
                'is_primary' =>'sometimes|boolean',
            ]);

            $product_images = Product_Images::create($validated);

            return response()->json([
                "message" => "Image Created Successfully",
                'data' => $product_images
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to create Image",
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function update_image(Request $request)
    {
        try {

            $validated = $request->validate([
                'id' => 'required|integer|exists:product__images,id',
                'product_id' =>'integer',
                'image_url' =>'url',
                'is_primary' =>'boolean',
            ]);

            $product_image = Product_Images::find($validated['id']);

            if (!$product_image) {
                return response()->json([
                    "message" => "Image not found",
                ], 404);
            }

            $product_image->update($validated);

            return response()->json([
                "message" => "Image Updated Successfully",
                'data' => $product_image
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to Update Image",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function delete_image(Request $request)
    {
        try {

            $validated = $request->validate([
                'id' => 'required|integer|exists:product__images,id'
            ]);

            $product_image = Product_Images::find($validated['id']);

            if (!$product_image) {
                return response()->json([
                    "message" => "Image not found",
                ], 404);
            }

            $product_image->delete();

            return response()->json([
                "message" => "Image Delete Successfully"
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to Update Image",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
