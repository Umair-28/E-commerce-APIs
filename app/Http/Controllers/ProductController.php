<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getAllProducts()
        {
            $products = Product::all();
            return response()->json($products);
        }

    public function addProduct(Request $req)
        {
            Product::create($req->all());
            return response()->json(['status'=>'Product added Successfully']);
        }  
        
    public function updateProduct(Request $req, $id)
        {   
            $product = Product::findOrFail($id);
            $product->update($req->all());
            return response()->json(['status'=>'Product Successfully Updated']);
        }
        
     public function deleteProduct($id)
        {
            Product::destroy($id);
            return response()->json(['message'=>'Product Deleted Successfully']);
        }   
}
