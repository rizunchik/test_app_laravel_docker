
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
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
    </thead>
    <tbody class="table-group-divider">
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><a href="{{ route('product.show', $product->id)}}">{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->cost }}</td>
                <td>{{ $product->cost }}</td>
                <td><a href="{{ route('product.edit', $product->id) }}"><i class="bi bi-pencil-square"></i></a></td>
                <td><i class="bi bi-trash-fill text-danger" data-bs-product-id="{{ $product->id }}" data-bs-product-name="{{ $product->name }}" data-bs-toggle="modal" data-bs-target="#modal_delete"></i></td>
            </tr>
        @endforeach

    </tbody>
  </table>

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

<script>
    var modelDelete = document.getElementById('modal_delete');
    modelDelete.addEventListener('show.bs.modal', function (event) {

        var button = event.relatedTarget;

        var product_id = button.getAttribute('data-bs-product-id');
        var product_name = button.getAttribute('data-bs-product-name');


        var modalHeaderH5 = modelDelete.querySelector('.modal-header h5');
        var modalFormDelete = modelDelete.querySelector('.modal-footer form');

        modalHeaderH5.textContent = 'Видалення товару ' + product_name;
        modalFormDelete.action = `products/${product_id}`;
    });
</script>

@endsection