
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Product {{ $product->name }}</h1>
    
@endsection
@section('content')


<table class="table">
    <thead>
        <tr>

            <th scope="col">Ціна</th>
            <th scope="col">Ціна зі знижкою</th>
            <th scope="col">Собівартість</th>
          </tr>
    </thead>
    <tbody class="table-group-divider">
        <tr>
            <td>{{ $product->price }}</td>
            
            <td>
                @if ($product->is_discount && (float)$product->discount_price > 0)
                    {{ $product->discount_price }}
                @else
                    {{ "-" }}
                @endif
            </td>

            <td>{{ $product->price }}</td>
        </tr>
    </tbody>
</table>

    
@php
$images  = $product->images->sortBy('position')->values();
$cover   = $product->primaryImage ?? $images->first();
$thumbs  = $images->filter(fn($i) => $cover?->id !== $i->id)->values();
$limit   = 7;                                
$rest    = max(0, $thumbs->count() - $limit);
@endphp

@if (count($images) > 0)
<div class="card p-3 mb-4">
    <div class="card-body">
  <h6 class="mb-3">Зображення</h6>

  <div class="d-flex align-items-start gap-3">
    <div class="ratio ratio-1x1" style="width:220px;">
      @if ($cover)
        <img src="{{ $cover->url('large') }}" class="rounded w-100 h-100" style="object-fit:cover" alt="">
      @endif
    </div>

    <div class="d-flex flex-wrap gap-3 flex-grow-1">
      @foreach ($thumbs->take($limit) as $img)
      <div class="ratio ratio-1x1 shadow-sm rounded position-relative" style="width:100px;">
        <img src="{{ $img->url('small') }}" class="rounded w-100 h-100" style="object-fit:cover" alt="">
      </div>
      @endforeach

      @if ($rest > 0)
        <div class="ratio ratio-1x1 rounded position-relative bg-body-secondary d-flex align-items-center justify-content-center" style="width:100px;">
          <span class="fs-5 text-secondary">+{{ $rest }}</span>
        </div>
      @endif

    </div>
    
  </div>
    </div>
</div>
@endif

{!! $product->description !!}

<div class="row justify-content-evenly mb-5">
  <div class="col-4">
      <a href="{{ route('product.edit', $product->id) }}"><button type="button" class="btn btn-primary" id="save">Редагувати</button></a>
  </div>
  <div class="col-4">
    <button type="button" class="btn btn-danger" data-bs-product-id="{{ $product->id }}" data-bs-product-name="{{ $product->name }}" data-bs-toggle="modal" data-bs-target="#modal_delete">
      Видалити товар
  </button>
  </div>
</div>



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