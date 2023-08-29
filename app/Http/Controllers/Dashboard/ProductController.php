<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        $categories = Category::all();

        return view('pages.Products.Products', compact('products', 'categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'sar_price' => 'required',
            'usd_price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
            'images' => 'required',
        ]);

        $product = new Product();

        $product->name = ['en' => $request->name_en, 'ar' => $request->name_ar];

        $product->description = ['en' => $request->description_en, 'ar' => $request->description_ar];

        $product->sar_price = $request->sar_price;

        $product->usd_price = $request->usd_price;

        $product->quantity = $request->quantity;

        $product->category_id = $request->category_id;

        $image = array();

        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'uploads/product_image/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $image_full_name);
                $image[] = $image_url;
            }
        }

        $product->image = implode('|', $image);
        $product->save();

        toastr()->success(trans('messages.success'));
        return redirect()->route('products.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'sar_price' => 'required',
            'usd_price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
        ]);

        $product = Product::findOrFail($request->id);

        $product->name = ['en' => $request->name_en, 'ar' => $request->name_ar];

        $product->description = ['en' => $request->description_en, 'ar' => $request->description_ar];

        $product->sar_price = $request->sar_price;

        $product->usd_price = $request->usd_price;

        $product->quantity = $request->quantity;

        $product->category_id = $request->category_id;

        if ($files = $request->file('images')) {

            $image = array();


            $images = explode('|', $product->image);
            foreach ($images as $img) {
                File::delete($img);
            }

            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'uploads/product_image/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $image_full_name);

                $image[] = $image_url;
            }
            $product->image = implode('|', $image);
        }

        $product->save();

        toastr()->success(trans('messages.Update'));
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product=Product::findOrFail($request->id);

        $images = explode('|', $product->image);
            foreach ($images as $img) {
                File::delete($img);
        }

        $product->delete();

        toastr()->success(trans('messages.Delete'));
        return redirect()->route('products.index');
    }

    public function Filter_Classes(Request $request)
    {
        $categories = Category::all();
        $Search = Product::select('*')->where('category_id', '=', $request->category_id)->get();
        return view('pages.Products.Products', compact('categories'))->withDetails($Search);
    }
}
