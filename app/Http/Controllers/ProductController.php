<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        $products = Product::all();

        return view('product.index', compact(('products')));
    }

    public function create(){

        return view('product.create');
    }

    public function store(){

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => 'string',
            'price' => ['decimal:0,2', 'min:0'],
            'discount_price' => ['nullable', 'decimal:0,2', 'min:0'],
            'cost' => ['decimal:0,2', 'min:0'],
        ]);

        Product::create($data);

        return redirect()->route('product.index');
        
    }

    public function show(Product $product){
        
        return view('product.show', compact('product'));

    }
}
