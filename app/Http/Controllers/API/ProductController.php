<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name = $request->input('name');
        $slug = $request->input('slug');
        $type = $request->input('type');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if($id) {
            $product = Product::with('galleries')->find($id);

            if($product) 
                return ResponseFormatter::success($product, 'Product berhasil diambil');
            else
                return ResponseFormatter::error(null, 'Product tidak ada', 404);
            
        }

        if($slug) {
            $product = Product::with('galleries')
            ->where('slug', $slug)
            ->first();

            if($product) 
                return ResponseFormatter::success($product, 'Product berhasil diambil');
            else
                return ResponseFormatter::error(null, 'Product tidak ada', 404);
            
        }


        $product = Product::with('galleries');

        if ($name)
            $product->where('name', 'like', '%' . $name . '%');
            
        if ($type)
            $product->where('type', 'like', '%' . $type . '%');

        if ($price_from)
            $product->where('price_from', '>=', $price_from);

        if ($price_to)
            $product->where('price_to', '<=', $price_to);


        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data List Product Berhasil Diambil'
        );
    }
}
