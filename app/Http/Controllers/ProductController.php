<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $validation = \Validator::make($request->input(), [
            "name" => "required|string|max:255",
            "quantity" => "required|integer",
            "price" => "required|integer",
        ]);

        if ($validation->fails()) {
            // dd($validation->errors());
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }
        $productData = $request->only(['name', 'quantity', 'price']);
        $productJsonData = json_encode($productData);
        if (file_put_contents('products.json', $productJsonData . '|', FILE_APPEND)) {
            return redirect()->back()->with(['message' => 'Successfuly inserted']);
        }
    }
}
