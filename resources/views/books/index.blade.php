@extends('books.layout')
@extends('layouts.base')
@section('content')

    <div style="display: flex; gap: 30px; margin-top: 20px;">
        <!-- БОКОВАЯ ПАНЕЛЬ (ваш шаблон) -->
        <aside class="sidebar" style="width: 250px; background: #f9f9f9; padding: 20px; border-radius: 12px;">
            <div class="sidebar-title" style="font-weight: 600; margin-bottom: 16px; color: #4a2e1e;">
                <i class="fas fa-sliders-h"></i>
                <span>Категории</span>
            </div>

            <!-- Поиск (по названию книги) -->
            <div class="category-search">
                <form method="GET" action="{{ route('books.index') }}">
                    <div class="search-box" style="position: relative; margin-bottom: 16px;">
                        <i class="fas fa-search"
                            style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
                        <input type="text" name="search" placeholder="Название книги..." value="{{ request('search') }}"
                            style="width: 100%; padding: 10px 10px 10px 35px; border: 1px solid #e0d5c9; border-radius: 20px; background: #fff;">
                    </div>
                    <!-- Скрытый инпут, чтобы при поиске не сбрасывался выбранный жанр (если он есть) -->
                    @if(request('genre'))
                        <input type="hidden" name="genre" value="{{ request('genre') }}">
                    @endif
                    <button type="submit" style="display: none;"></button>
                </form>
            </div>

            <!-- Список жанров -->
            <ul class="category-list" style="list-style: none; padding: 0; margin: 0;">
                <!-- Пункт "Все" -->
                <li style="margin-bottom: 6px;">
                    <a href="{{ route('books.index', ['search' => request('search')]) }}"
                        style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px; border-radius: 18px; text-decoration: none; color: #3f2a1c; {{ !request('genre') ? 'background: #fef6f0; font-weight: 600;' : '' }}">
                        <span>
                            <i class="fas fa-list" style="width: 20px; color: var(--orange-soft);"></i>
                            Все категории
                        </span>
                        <span class="count"
                            style="background: #f0e2d0; padding: 2px 8px; border-radius: 12px; font-size: 0.8em;">
                            {{ $totalBooksCount }}
                        </span>
                    </a>
                </li>
                @foreach($genres as $genre => $icon)
                    <li style="margin-bottom: 6px;">
                        <a href="{{ route('books.index', ['genre' => $genre, 'search' => request('search')]) }}"
                            style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px; border-radius: 18px; text-decoration: none; color: #3f2a1c; {{ request('genre') == $genre ? 'background: #fef6f0; font-weight: 600;' : '' }}">
                            <span>
                                <i class="fas {{ $icon }}" style="width: 20px; color: var(--orange-soft);"></i>
                                {{ $genre }}
                            </span>
                            <span class="count"
                                style="background: #f0e2d0; padding: 2px 8px; border-radius: 12px; font-size: 0.8em;">
                                {{ $genreCounts[$genre] ?? 0 }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Блок Популярное -->
            <div style="margin-top: 32px;">
                <div style="font-weight: 600; margin-bottom: 16px; color: #4a2e1e;">
                    <i class="far fa-star" style="color: var(--orange-soft);"></i> Популярное
                </div>
                <a href="{{ route('books.index', ['new' => 1, 'search' => request('search'), 'genre' => request('genre')]) }}"
                    style="display:block; background: #fef6f0; padding: 12px 14px; border-radius: 18px; text-decoration: none; color:#3f2a1c; margin-bottom: 8px;">
                    <i class="fas fa-tag" style="color: var(--orange-soft);"></i> Новинки недели
                </a>
                <a href="#"
                    style="display:block; background: #fef6f0; padding: 12px 14px; border-radius: 18px; text-decoration: none; color:#3f2a1c;">
                    <i class="fas fa-crown" style="color: var(--orange-soft);"></i> Бестселлеры
                </a>
            </div>
        </aside>

        <!-- Основной контент -->
        <div style="flex: 1;">
            <div class="book-grid">
                @forelse($books as $book)
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
                                <div class="book-genre" style="font-size: 0.8em; color: #888;">{{ $book->genre ?? 'Без жанра' }}
                                </div>
                            </div>
                        </a>
                        <div style="display: flex; gap: 5px; margin-top: 10px;">
                            <a href="{{ route('books.edit', $book) }}" class="btn" style="flex:1;">✏️</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" style="flex:1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width:100%;"
                                    onclick="return confirm('Удалить книгу?')">🗑️</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Книги не найдены. Измените параметры поиска.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection