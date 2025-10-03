@extends('layouts.layout')



@section('h2_block')
    <h1 class="h2">Товари</h1>
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

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Назва">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Опис</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
        </div>
    </div>


    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p>Зображення</p>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Ви можете завантажити зображення до 10Mb</label>
                <input class="form-control" type="file" name="images[]" id="formFileMultiple" accept="image/png,image/jpeg,image/webp" multiple>
            </div>
        </div>
    </div>

  
  <div class="card shadow-sm mb-4">
    <div class="card-body">
        <p>Ціни</p>
        <label for="price" class="form-label">Ціна</label>
        <div class="input-group mb-3">
            <span class="input-group-text">₴</span>
            <input type="text" name="price" id="price" class="form-control">
        </div>

        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_discount" id="is_discount" role="switch" id="switchCheckChecked" checked value="0">
            <label class="form-check-label" for="is_discount">Знижка</label>
        </div>

        <label for="price" class="form-label">Ціна зі знижкою</label>
        <div class="input-group mb-3">
            <span class="input-group-text">₴</span>
            <input type="text" name="discount_price" id="discount_price" class="form-control" >
        </div>

        <div class="row">
            <div class="col">
                <label for="cost" class="form-label">Собівартість</label>
                <div class="input-group">
                    <span class="input-group-text">₴</span>
                    <input type="text" name="cost" id="cost" class="form-control">
                </div>
                
            </div>
            <div class="col input-group">
                <label for="profit" class="form-label">Прибуток</label>
                <div class="input-group">
                    <span class="input-group-text">₴</span>
                    <input type="text" ame="profit" id="profit" class="form-control">
                </div>
                
            </div>
            <div class="col input-group">
                <label for="marga" class="form-label">Маржа</label>
                <div class="input-group">
                    <span class="input-group-text">₴</span>
                    <input type="text" ame="marga" id="marga" class="form-control">
                </div>
            </div>
        </div>
    
    </div>
  </div>

  <div class="col-12">
    <button class="btn btn-primary" type="submit">Зберегти</button>
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

@endsection



