@extends('layouts.layout')



@section('h2_block')
    <h1 class="h2">Редагування товару {{ $product->name }}</h1>
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
@endif

@error('name')
    <div class="text-red-600">{{ $message }}</div>
@enderror

<form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Назва" value="{{ $product->name }}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Опис</label>
                <textarea class="form-control" name="description" id="description" rows="3">{!! old('description', $product->description ?? '') !!}</textarea>
            </div>
        </div>
    </div>

    @php
  // впевнись, що в контролері: Product::with(['primaryImage','images'])->find($id)
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


  
  <div class="card shadow-sm mb-4">
    <div class="card-body">
        <p>Ціни</p>
        <label for="price" class="form-label">Ціна</label>
        <div class="input-group mb-3">
            <span class="input-group-text">₴</span>
            <input type="text" name="price" id="price" class="form-control" value="{{ $product->price }}">
        </div>

        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_discount" id="is_discount" role="switch" id="switchCheckChecked" checked value="{{ $product->is_discount }}">
            <label class="form-check-label" for="is_discount">Знижка</label>
        </div>

        <label for="price" class="form-label">Ціна зі знижкою</label>
        <div class="input-group mb-3">
            <span class="input-group-text">₴</span>
            <input type="text" name="discount_price" id="discount_price" class="form-control" value="{{ $product->discount_price }}">
        </div>

        <div class="row">
            <div class="col">
                <label for="cost" class="form-label">Собівартість</label>
                <div class="input-group">
                    <span class="input-group-text">₴</span>
                    <input type="text" name="cost" id="cost" class="form-control" value="{{ $product->cost }}">
                </div>
                
            </div>
            <div class="col input-group">
                <label for="price" class="form-label">Прибуток</label>
                <div class="input-group">
                    <span class="input-group-text">₴</span>
                <input type="text" class="form-control">
                </div>
                
            </div>
            <div class="col input-group">
                <label for="price" class="form-label">Маржа</label>
                <div class="input-group">
                    <span class="input-group-text">₴</span>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
    
    </div>
  </div>

  <div class="col-12">
    <button class="btn btn-primary" type="submit">Оновити</button>
</div>

</form>
<script src="https://cdn.tiny.cloud/1/dokpt4hqr4uy2ym94l9ddaxrap7t336r9nlzsitc5eni3t4q/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
    tinymce.init({
      selector: 'textarea#description',
      plugins: [
        // Core editing features
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
        // Your account includes a free trial of TinyMCE premium features
        // Try the most popular premium features until Oct 17, 2025:
        'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
      ],
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
      uploadcare_public_key: '095956eebcc4fa01f730',
    });
  </script>

<script>
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.js-del');
    //   if (!btn) return;
    
    //   const tile = btn.closest('[data-id]');
    //   const id = tile?.dataset?.id || btn.dataset.id; // для головного фото
      const id = btn.getAttribute('data-image-id'); 
      console.log(id);
    //   if (!id) return;

      const closestParent = btn.closest('.ratio');
      closestParent.remove();


      const holder = document.getElementById('delete-inputs');
      const existing = holder.querySelector(`input[name="delete_images[]"][value="${id}"]`);
      if (existing) {
        existing.remove();
      } else {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_images[]';
        input.value = id;
        holder.appendChild(input);
      }
    });
    </script>
    

@endsection



