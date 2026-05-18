@extends('books.layout')
@include('layouts.base')

@section('content')
<div style="display:inline;">
    <div style="width: 300px; height: 400px;">
        @if($book->image)
        
        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" style="width:100%; height:100%; object-fit:contain;">
        
        @else

        <i class="fas fa-book" style="font-size: 100px;"></i>
        
        @endif
    </div>
    <div>
            <h1><strong>Книга: </strong>{{ $book->title }}</h1>
            <p><strong>Автор:</strong> {{ $book->author }}</p>
            <p><strong>Жанр:</strong> {{ $book->genre ?? 'Не указан' }}</p>
            <p><strong>Цена:</strong> {{ number_format($book->price, 0, ',', ' ') }} ₽</p>
            @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
            <div>
                <a href="{{ route('books.edit', $book) }}" class="btn">Редактировать</a>
                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить книгу?')">Удалить</button>
                </form>
            </div>
            @endif
            @include('cart.button')
            @endauth
            <br>
            <a href="{{ route('books.index') }}" class="btn">Назад к каталогу</a>
        </div>
    </div>
@endsection