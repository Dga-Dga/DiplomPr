@extends('books.layout')

@push('layouts.base')


@section('content')
    <h1>Добавить книгу</h1>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Название:</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
            @error('title') <div">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Автор:</label>
            <input type="text" name="author" value="{{ old('author') }}" required>
            @error('author') <div">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Цена (₽):</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
            @error('price') <div">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 15px;">
    <label>Изображение обложки:</label>
    <input type="file" name="image" id="imageInput" accept="image/*" required>
    @error('image') <div>{{ $message }}</div> @enderror
    
    <div id="imagePreview" style="margin-top: 10px; display: none;">
        <img id="previewImg" src="#" alt="Предпросмотр" style="max-width: 200px; max-height: 200px;">
    </div>
</div>

        <button type="submit" class="btn">Сохранить</button>
        <a href="{{ route('books.index') }}" class="btn">Отмена</a>
    </form>
    <script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const img = document.getElementById('previewImg');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.style.display = 'none';
            img.src = '#';
        }
    });
</script>
@endsection