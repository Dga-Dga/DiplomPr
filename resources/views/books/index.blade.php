@extends('books/layout')
@extends('layouts/base')
@section('content')
    <h1>Каталог книг</h1>

    <div class="book-grid">
        @foreach($books as $book)
            <div class="book-card">
                <a href="{{ route('books.show', $book) }}" style="text-decoration: none; color: inherit;">
                    <div class="book-cover">
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                        @else
                            <i class="fas fa-book"></i>
                        @endif
                    </div>
                    <div class="book-info">
                        <div class="book-title">{{ $book->title }}</div>
                        <div class="book-author">{{ $book->author }}</div>
                        <div class="book-price">{{ number_format($book->price, 0, ',', ' ') }} ₽</div>
                    </div>
                </a>
                <div class="book-info">
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-card">Редактировать</a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" style="flex:1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-card" onclick="return confirm('Удалить книгу?')">Удалить</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection