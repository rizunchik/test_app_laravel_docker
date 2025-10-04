
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Товари</h1>
    <a class="btn btn-primary" href="{{ route('product.create') }}" role="button">Додати товар</a>
@endsection
@section('content')
<div class="border rounded-3 overflow-hidden mb-4">
  <table class="table mb-0">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Назва</th>
            <th scope="col">Ціна</th>
            <th scope="col">Собівартість</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
    </thead>
    <tbody class="table-group-divider">
        @foreach($products as $product)
            <tr>
                <td>

                  <img
                    src="{{ $product->primaryImage?->url('small')
                          ?? $product->images->first()?->url('small')
                          ?? asset('images/no-image.webp') }}"
                    class="img-thumbnail" width="50" height="50">

                </td>
                <td><a href="{{ route('product.show', $product->id)}}">{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->cost }}</td>
                <td><a href="{{ route('product.edit', $product->id) }}"><i class="bi bi-pencil-square"></i></a></td>
                <td><i class="bi bi-trash-fill text-danger" data-bs-product-id="{{ $product->id }}" data-bs-product-name="{{ $product->name }}" data-bs-toggle="modal" data-bs-target="#modal_delete"></i></td>
            </tr>
        @endforeach

    </tbody>
  </table>
</div>


  <!-- Modal -->
  <div class="modal fade" id="modal_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Видалення</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Ви впевнені, що хочете видалити товар?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Скасувати</button>
            <form action="" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">Видалити</button>
            </form>
        </div>
      </div>
    </div>
  </div>


@endsection