<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Session;
use Image;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session::put('menu', 'products');
        $pagetitle = 'Products';
        $products  = Product::latest()->paginate(5);
        return  view('products.index', compact('products', 'pagetitle'));
        // return view('products.index', compact('products'))
        // ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required'
        ]);
        $imageName = null;
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->extension();
            $destinationPath = public_path('/uploads/products');
            $thumbnail = public_path('/uploads/products/thumbnail');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
                if (!File::isDirectory($thumbnail)) {
                    File::makeDirectory($thumbnail, 0777, true, true);
                }
                // retry storing the file in newly created path.
            }

            $img = Image::make($image->path());
            $img->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnail . '/' . $imageName); 
            $image->move($destinationPath, $imageName);
        }
        $input['image'] = $imageName;
        Product::create($input);
        return redirect()->route('products.index')->with([
            'message' => 'Product saved successfully!',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        session::put('menu', 'Products');
        $pagetitle = 'Products';
        $products = Product::get();
        return view('products.index', compact('products', 'product', 'pagetitle'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $destinationPath = public_path('/uploads/products/thumbnail');
            $img = Image::make($image->path());
            $img->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
            $destinationPath = public_path('uploads');
            $image->move($destinationPath, $imageName);
            if ($product->image) {
                \Storage::delete('public/uploads/products/thumbnail/' . $product->image);
                \Storage::delete('public/uploads/products/' . $product->image);
            }
        } else {
            $imageName = $product->image;
        }

        $product->name = $request->input('name');
        $product->description = trim($request->input('description'));
        $product->price = trim($request->input('price'));
        $product->image = $imageName;
        $product->save();
        return redirect()->route('products.index')->with([
            'message' => 'product updated successfully!',
            'status' => 'success'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
