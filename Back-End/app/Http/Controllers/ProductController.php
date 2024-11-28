<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     *   Uploding the Product Image 
     */
    public function uploadProductImage(Request $request)
    {
        $request->validate(['Product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',]);
        $product = Product::findOrFail($request->product_id);
        $imageName = $product->productName->extension();
        $request->Product_image->move(public_path('Product_image'), $imageName);
        // If the Product already has a profile image, delete the old one
        if ($product->Product_image) {
            Storage::delete('Product_image/' . $product->Product_image);
        }
        $product->Product_image = $imageName;
        $product->save();
        return back()->with('success', 'Product_image updated successfully.')->with('Product_image', $imageName);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
