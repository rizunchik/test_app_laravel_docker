
@extends('layouts.layout')

@section('h2_block')
    <h1 class="h2">Product {{ $product->name }}</h1>
@endsection
@section('content')

    
@php
$images  = $product->images->sortBy('position')->values();
$cover   = $product->primaryImage ?? $images->first();
$thumbs  = $images->filter(fn($i) => $cover?->id !== $i->id)->values();
$limit   = 7;                                // скільки мініатюр показувати
$rest    = max(0, $thumbs->count() - $limit);
@endphp

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

{!! $product->description !!}
    
@endsection