
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Product</h1>
@endsection
@section('content')


    @foreach($products as $product)
        <p>{{ $product->name }}</p>
    @endforeach
    
@endsection