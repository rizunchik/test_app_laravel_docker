
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Product {{ $product->name }}</h1>
@endsection
@section('content')

    {!! $product->description !!}
    
@endsection