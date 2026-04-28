@extends('books.layout')

@section('content')
    <h1>Редактировать: {{ $book->title }}</h1>

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Название:</label>
            <input type="text" name="title" value="{{ old('title', $book->title) }}" required>
            @error('title') <div style="color:red;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Жанр:</label>
            <select name="genre">
                <option value="">Выберите жанр</option>
                @foreach($genres as $name => $icon)
                    <option value="{{ $name }}" {{ old('genre', $book->genre) == $name ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('genre') <div style="color:red;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Автор:</label>
            <input type="text" name="author" value="{{ old('author', $book->author) }}" required>
            @error('author') <div style="color:red;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 15px;"> <label>Цена (₽):</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $book->price) }}" required>
            @error('price') <div style="color:red;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Текущее изображение:</label><br>
            @if($book->image)
                <img src="{{ asset('storage/' . $book->image) }}" id="currentImage"
                    style="max-width: 200px; max-height: 200px;"><br>
            @else
                <p>Нет изображения</p>
            @endif

            <label>Заменить изображение (необязательно):</label>
            <input type="file" name="image" id="imageInput" accept="image/*">
            @error('image') <div style="color:red;">{{ $message }}
            </div> @enderror

            <div id="newImagePreview" style="margin-top: 10px; display: none;">
                <p>Новое изображение:</p>
                <img id="previewImg" src="#" alt="Предпросмотр" style="max-width: 200px; max-height: 200px;">
            </div>
        </div>

        <button type="submit" class="btn">Обновить</button>
        <a href="{{ route('books.index') }}" class="btn">Отмена</a>
    </form>
    <script>
        document.getElementById('imageInput').addEventListener('change', function (e) {
            const previewDiv = document.getElementById('newImagePreview');
            const img = document.getElementById('previewImg');

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                    previewDiv.style.display = 'block';
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                previewDiv.style.display = 'none';
                img.src = '#';
            }
        });
    </script>
@endsection