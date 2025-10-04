<?php

namespace App\Http\Controllers;

use App\Jobs\UploadProductImage;
use App\Jobs\DeleteProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;


class ProductController extends Controller
{
    public function index(){


        $products = Product::all();

        return view('product.index', compact(('products')));
    }

    public function create(){

        return view('product.create');
    }

    public function store(Request $request){

        $validated = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['decimal:0,2', 'min:0'],
            'discount_price' => ['nullable', 'decimal:0,2', 'min:0'],
            'cost' => ['decimal:0,2', 'min:0'],
            'images' => ['nullable','array'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:10240'],
        ]);

        $data = Arr::except($validated, ['images']);

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            
            foreach ($request->file('images') as $i => $file) {
                
                $tmpPath = $file->storeAs(
                    'tmp/products',
                    \Illuminate\Support\Str::uuid().'.'.$file->getClientOriginalExtension(),
                    'local'
                );
    
                UploadProductImage::dispatch(
                    productName: $product->name,
                    productId:  $product->id,
                    tmpPath:    $tmpPath,
                    position:   $i,
                    isPrimary:  $i === 0,  
                )->onQueue('default');
            }
        }

        return redirect()->route('product.index');
        
    }

    public function show(Product $product){
        
        return view('product.show', compact('product'));

    }
    
    public function edit(Product $product){
        
        return view('product.edit', compact('product'));

    }

    public function update(Request $request, Product $product){

        $validated = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => 'string',
            'price' => ['decimal:0,2', 'min:0'],
            'discount_price' => ['nullable', 'decimal:0,2', 'min:0'],
            'cost' => ['decimal:0,2', 'min:0'],
            'images'         => ['nullable','array'],
            'images.*'       => ['image','mimes:jpg,jpeg,png,webp','max:10240'],

            'delete_images'  => ['nullable','array'],
            'delete_images.*'=> ['integer'],

        ]);

        $data = Arr::except($validated, ['images','delete_images']);

        $product->update($data);

        $deleteImagesIds = ($validated['delete_images']  ?? []);

        if ($deleteImagesIds) {

            DeleteProductImage::dispatch(
                deleteImagesIds: $deleteImagesIds,
                productId:  $product->id,
            )->onQueue('default');

        }

        if ($request->hasFile('images')) {
            
            foreach ($request->file('images') as $i => $file) {
                
                $tmpPath = $file->storeAs(
                    'tmp/products',
                    \Illuminate\Support\Str::uuid().'.'.$file->getClientOriginalExtension(),
                    'local'
                );
    
                UploadProductImage::dispatch(
                    productName: $product->name,
                    productId:  $product->id,
                    tmpPath:    $tmpPath,
                    position:   $i,
                    isPrimary:  $i === 0,  
                )->onQueue('default');
            }
        }

        return view('product.show', compact('product'));
    }

    public function destroy(Product $product){

        $product->delete();

        return redirect()->route('product.index');

    }
}
