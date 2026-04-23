@extends('books.layout')

@section('content')
    <h1>{{ $book->title }}</h1>
    <div style="display: flex; gap: 30px;">
        <div class="book-cover" style="width: 300px; height: 400px;">
            @if($book->image)
                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" style="width:100%; height:100%; object-fit:contain;">
            @else
                <i class="fas fa-book" style="font-size: 100px;"></i>
            @endif
        </div>
        <div>
            <p><strong>Автор:</strong> {{ $book->author }}</p>
            <p><strong>Цена:</strong> {{ number_format($book->price, 0, ',', ' ') }} ₽</p>
            <div style="margin-top: 20px;">
                <a href="{{ route('books.edit', $book) }}" class="btn">Редактировать</a>
                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить книгу?')">Удалить</button>
                </form>
                <a href="{{ route('books.index') }}" class="btn">Назад к каталогу</a>
            </div>
        </div>
    </div>
@endsection