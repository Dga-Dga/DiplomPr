@extends('books.layout')
@include('layouts.base')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h2 style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px;">
        <i class="fas fa-heart" style="color: var(--orange-soft);"></i> Избранное
        @if($favorites->count())
            <span style="font-size: 0.9rem; color: #888;">({{ $favorites->total() }})</span>
        @endif
    </h2>

    @if($favorites->isEmpty())
        <p>У вас пока нет избранных книг. <a href="{{ route('books.index') }}">Перейти к каталогу</a></p>
    @else
        <div class="book-grid">
            @foreach($favorites as $book)
                <div class="book-card">
                    <a href="{{ route('books.show', $book) }}" style="text-decoration: none; color: inherit;">
                        <div class="book-cover" style="position: relative; height: 350px; overflow: hidden;">
                            @if($book->image)
                                <img style="width: 100%; height: 100%; object-fit: cover;" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                            @else
                                <i class="fas fa-book" style="font-size: 48px; color: #aaa;"></i>
                            @endif
                        </div>
                        <div class="book-info">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-price">{{ number_format($book->price, 0, ',', ' ') }} ₽</div>
                            <div class="book-author">{{ $book->author }}</div>
                            <div class="book-genre">{{ $book->genre ?? 'Без жанра' }}</div>
                        </div>
                    </a>
                    <button class="btn buy-btn" style="width:100%; margin-top:10px;">Купить</button>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 30px; display: flex; justify-content: center;">
            {{ $favorites->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
@endsection