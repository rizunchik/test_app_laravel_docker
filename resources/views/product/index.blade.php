
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Product</h1>
@endsection
@section('content')

<ul class="list-group">
    @foreach($products as $product)
        <li class="list-group-item">
            <a href="{{ route('product.show', $product->id)}}">{{ $product->name }}</a>
        </li>
    @endforeach
  </ul>

@endsection