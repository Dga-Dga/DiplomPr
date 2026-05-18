@extends('books.layout')

@include('layouts.base')

@section('content')

    @include('includes.slider')

    <div style="display: flex; gap: 30px; margin-top: 20px;">
        <!-- БОКОВАЯ ПАНЕЛЬ  -->
        <aside class="sidebar">
            <div class="sidebar-title">
                <i class="fas fa-sliders-h"></i>
                <span>Категории</span>
            </div>

            <!-- Список жанров -->
            <ul class="category-list">
                <!-- Пункт "Все" -->
                <li>
                    <a href="{{ route('books.index', ['search' => request('search')]) }}"
                        style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px; border-radius: 18px; text-decoration: none; color: #3f2a1c; {{ !request('genre') ? 'background: #fef6f0; font-weight: 600;' : '' }}">
                        <span>
                            <i class="fas fa-list" style="width: 20px; color: var(--orange-soft);"></i>
                            Все категории
                        </span>
                        <span class="count">
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
                {{-- <a href="#"
                    style="display:block; background: #fef6f0; padding: 12px 14px; border-radius: 18px; text-decoration: none; color:#3f2a1c;">
                    <i class="fas fa-crown" style="color: var(--orange-soft);"></i> Бестселлеры
                </a> --}}
            </div>
        </aside>

        <!-- Основной контент -->
        <main class="content">
            <div class="book-grid">
                @forelse($books as $book)
                    <div class="book-card">

                        <a href="{{ route('books.show', $book) }}" style="text-decoration: none; color: inherit;">
                            <div class="book-cover" style="position: relative; height: 350px; overflow: hidden;">
                                @if($book->image)
                                    <img style="width: 100%; height: 100%; object-fit: cover; display: block;"
                                        src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                                @else
                                    <i class="fas fa-book" style="font-size: 48px; color: #aaa;"></i>
                                @endif

                                <!-- Кнопка редактировать (левый верхний угол -->
                                @auth       
                                @include('admin.buttons')
                                @include('favorites.button')
                                @endauth
                            </div>

                            <div class="book-info">
                                <div class="book-title">{{ $book->title }}</div>
                                <div class="book-price">{{ number_format($book->price, 0, ',', ' ') }} ₽</div>
                                <div class="book-author">{{ $book->author }}</div>
                                <div class="book-genre" style="font-size: 0.8em; color: #888;">{{ $book->genre ?? 'Без жанра' }}
                                </div>
                            </div>
                        </a>

                        @include('cart.button')
                        
                    </div>
                @empty
                    <p>Книги не найдены. Измените параметры поиска.</p>
                @endforelse

            </div>
            {{-- Штука для новых книг, которые могли не поместиться на страницу --}}
            <div style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $books->links('pagination::bootstrap-4') }}
            </div>
        </main>
    </div>
@endsection