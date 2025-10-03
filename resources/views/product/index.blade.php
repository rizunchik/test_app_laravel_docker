
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Product</h1>
@endsection
@section('content')

  <table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Назва</th>
            <th scope="col">Ціна</th>
            <th scope="col">Собівартість</th>
          </tr>
    </thead>
    <tbody class="table-group-divider">
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><a href="{{ route('product.show', $product->id)}}">{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->cost }}</td>
            </tr>
        @endforeach

    </tbody>
  </table>

@endsection