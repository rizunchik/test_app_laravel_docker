
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Product {{ $product->name }}</h1>
@endsection
@section('content')

    


<div class="card p-3 mb-4">
    <div class="card-body">
  <h6 class="mb-3">Зображення</h6>

  <div class="d-flex align-items-start gap-3">

    {{-- Велике «головне» фото --}}
    <div class="ratio ratio-1x1" style="width:220px;">
      @if ($cover)
        <img src="{{ $cover->url('large') }}" class="rounded w-100 h-100" style="object-fit:cover" alt="">
        <button type="button"
                class="js-del btn btn-light btn-sm p-1 position-absolute top-0 end-0 m-1 w-auto h-auto"
                data-image-id="{{ $cover->id }}"
                aria-label="Видалити">
          <i class="bi bi-trash-fill text-danger"></i>
        </button>
      @endif
    </div>

    <div class="d-flex flex-wrap gap-3 flex-grow-1">

      @foreach ($thumbs->take($limit) as $img)
      <div class="ratio ratio-1x1 shadow-sm rounded position-relative" style="width:100px;">
        <img src="{{ $img->url('small') }}" class="rounded w-100 h-100" style="object-fit:cover" alt="">
      
        <button type="button"
                class="js-del btn btn-light btn-sm p-1 position-absolute top-0 end-0 m-1 w-auto h-auto"
                data-image-id="{{ $img->id }}"
                aria-label="Видалити">
          <i class="bi bi-trash-fill text-danger"></i>
        </button>
      </div>
      @endforeach

      @if ($rest > 0)
        <div class="ratio ratio-1x1 rounded position-relative bg-body-secondary d-flex align-items-center justify-content-center" style="width:100px;">
          <span class="fs-5 text-secondary">+{{ $rest }}</span>
        </div>
      @endif

    </div>
    
  </div>
    <div class="mb-3">
        <label for="formFileMultiple" class="form-label">Ви можете завантажити зображення до 10Mb</label>
        <input class="form-control" type="file" name="images[]" id="formFileMultiple" accept="image/png,image/jpeg,image/webp" multiple>
    </div>
    <div id="delete-inputs"></div>
    </div>
</div>

{!! $product->description !!}
    
@endsection