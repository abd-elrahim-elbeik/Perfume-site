<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::FindOrFail($id);

        return response()->json($products);
    }

}
