@extends('layouts.base')
@section('content')

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
                                    <img style="width: 100%; height: 100%; object-fit: cover; display: block;" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                                @else
                                    <i class="fas fa-book" style="font-size: 48px; color: #aaa;"></i>
                                @endif

                                <!-- Кнопка редактировать (левый верхний угол -->
                                @auth
                                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                        <a href="{{ route('books.edit', $book) }}" class="cover-action edit-action"
                                            title="Редактировать">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <!-- Кнопка удалить левый нижний угол -->
                                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                                            class="cover-action delete-action" onsubmit="return confirm('Удалить книгу?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Удалить">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                    @endif
                                @endauth
                                </form>
                            </div>

                            <div class="book-info">
                                <div class="book-title">{{ $book->title }}</div>
                                <div class="book-price">{{ number_format($book->price, 0, ',', ' ') }} ₽</div>
                                <div class="book-author">{{ $book->author }}</div>
                                <div class="book-genre" style="font-size: 0.8em; color: #888;">{{ $book->genre ?? 'Без жанра' }}
                                </div>
                            </div>
                        </a>

                        <!-- Кнопка купить (вместо старых кнопок) -->
                        <div class="book-actions" style="margin-top: 10px;">
                            <button class="btn buy-btn" data-added="false">
                                <span>Купить</span>
                            </button>
                        </div>
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
    <br>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buyButtons = document.querySelectorAll('.buy-btn');

            buyButtons.forEach(btn => {
                btn.addEventListener('click', function (event) {
                    // Чтобы клик по кнопке не переходил по ссылке родительской <a>
                    event.preventDefault();
                    event.stopPropagation();

                    const isAdded = this.getAttribute('data-added') === 'true';
                    if (isAdded) {
                        this.setAttribute('data-added', 'false');
                        this.innerHTML = '<span>Купить</span>';
                        this.classList.remove('added');
                    } else {
                        this.setAttribute('data-added', 'true');
                        this.innerHTML = '<span>В корзине</span>';
                        this.classList.add('added');
                    }
                });
            });
        });
    </script>
@endsection

@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
  --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
    'Segoe UI Symbol', 'Noto Color Emoji';
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}

body {
  font-family: "Inter", sans-serif;
  background-color: #fefaf5;
  color: #2e241e;
  line-height: 1.5;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}


a,
button,
input,
.book-card,
.sidebar a,
.btn {
  transition: all 0.25s ease-in-out;
}

:root {
  --orange-soft: #f5a65b;
  --orange-light: #fce6d4;
  --orange-deep: #e0893c;
  --orange-warm: #d9782b;
  --white-soft: #ffffff;
  --gray-warm: #f9f3ed;
  --shadow-sm: 0 8px 20px rgba(0, 0, 0, 0.04), 0 2px 6px rgba(0, 0, 0, 0.03);
  --shadow-hover: 0 18px 30px -8px rgba(245, 166, 91, 0.18), 0 6px 12px -4px rgba(0, 0, 0, 0.05);
  --border-radius-card: 20px;
  --border-radius-btn: 40px;
}

.container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 24px;
}

.btn {
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  text-decoration: none;
  line-height: 1;
  box-shadow: 0 2px 6px rgba(245, 166, 91, 0.08);
  backdrop-filter: blur(2px);
}

.btn i {
  font-size: 1rem;
}

.btn:hover {
  background: var(--orange-soft);
  color: white;
  border-color: var(--orange-soft);
  box-shadow: 0 8px 14px -6px rgba(245, 166, 91, 0.4);
  transform: translateY(-1px);
}

.header {
  background: var(--white-soft);
  padding: 16px 0;
  border-bottom: 1px solid #ffede1;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
  position: sticky;
  top: 0;
  z-index: 10;
  backdrop-filter: blur(4px);
  background: rgba(255, 255, 255, 0.9);
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  flex-wrap: wrap;
  gap: 16px 24px;
}

.logo {
  font-size: 35px;
  font-weight: 700;
  letter-spacing: -0.02em;
  color: var(--orange-deep);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
}

.logo i {
  font-size: 2rem;
  color: var(--orange-soft);
}

.logo span {
  background: linear-gradient(145deg, #e0893c 0%, #f5a65b 80%);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.search-wrapper {
  flex: 1;
  max-width: 720px;
  min-width: 260px;
}

.search-bar {
  display: flex;
  align-items: center;
  background-color: rgb(247, 247, 247);
  border-radius: 48px;
  padding: 4px 4px 4px 20px;
  border: 1.5px solid transparent;
  transition: all 0.2s;
}

.search-bar:focus-within {
  border-color: var(--orange-soft);
  background: white;
  box-shadow: 0 0 0 4px rgba(245, 166, 91, 0.12);
}

.search-bar i {
  color: var(--orange-soft);
  font-size: 20px;
}

.search-bar input {
  flex: 1;
  border: none;
  background: transparent;
  padding: 14px 12px;
  font-size: 1rem;
  outline: none;
  font-family: inherit;
}

.search-bar button {
  background: var(--orange-soft);
  border: none;
  color: white;
  padding: 12px 24px;
  border-radius: 40px;
  font-weight: 600;
  cursor: pointer;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: 0.2s;
  border: 1px solid var(--orange-soft);
}

.search-bar button:hover {
  background: var(--orange-deep);
  transform: scale(1.02);
}

.header-actions {
  display: flex;
  gap: 16px;
  align-items: center;
}

.header-actions a {
  color: #4a3b32;
  font-size: 1.4rem;
  padding: 8px;
  border-radius: 50%;
  background: transparent;
}

.header-actions a:hover {
  background: var(--orange-light);
  color: var(--orange-deep);
}

.main-grid {
  display: flex;
  gap: 32px;
  margin: 40px 0 60px;
}

.sidebar {
  flex: 0 0 260px;
  background: var(--white-soft);
  border-radius: 28px;
  padding: 24px 20px;
  box-shadow: var(--shadow-sm);
  height: fit-content;
  border: 1px solid #ffede1;
  transition: box-shadow 0.3s;
}

.sidebar:hover {
  box-shadow: var(--shadow-hover);
}

.sidebar-title {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 20px;
  color: #4a2e1e;
  display: flex;
  align-items: center;
  gap: 8px;
}

.sidebar-title i {
  color: var(--orange-soft);
}

.category-list {
  list-style: none;
}

.category-list li {
  margin-bottom: 6px;
}

.category-list a {
  display: flex;
  align-items: center;
  padding: 12px 14px;
  border-radius: 18px;
  text-decoration: none;
  color: #3f2e23;
  font-weight: 500;
  background: transparent;
  gap: 12px;
}

.category-list a i {
  width: 20px;
  color: var(--orange-soft);
  font-size: 1rem;
}

.category-list a:hover {
  background: var(--orange-light);
  color: var(--orange-deep);
  padding-left: 18px;
}

.category-list .count {
  margin-left: auto;
  font-size: 0.8rem;
  color: #b28b73;
  background: #f5ede7;
  padding: 2px 8px;
  border-radius: 30px;
}

.content {
  flex: 1;
}

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: baseline;
  margin-bottom: 28px;
}

.content-header h2 {
  font-size: 1.9rem;
  font-weight: 700;
  color: #3f2a1c;
}

.content-header h2 i {
  color: var(--orange-soft);
  margin-right: 8px;
}

.sort-badge {
  color: #8e6f5c;
  background: #f1e3da;
  padding: 8px 16px;
  border-radius: 30px;
  font-size: 0.9rem;
}

.book-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
  padding: 20px;
}

.book-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 10px;
  text-align: center;
  background: #fff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  flex-direction: column;
  transition: all 0.3s cubic-bezier(0.15, 0.75, 0.4, 1);
  animation: cardFadeIn 0.6s ease-out;
}


@keyframes cardFadeIn {
  0% {
    opacity: 0;
    transform: translateY(14px);
  }

  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.book-card:hover {
  transform: translateY(-10px);
  box-shadow: var(--shadow-hover);
  border-color: var(--orange-soft);
}

.book-cover {
  position: relative;
  height: 350px;
  overflow: hidden;
}


.book-card:hover .book-cover {
  color: #d9782b;
  background: linear-gradient(145deg, #fae2d1, #f7d5bd);
}

.book-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.book-info {
  margin-bottom: 10px;
}

.book-title {
  font-weight: 700;
  font-size: 1.1rem;
  margin-bottom: 6px;
  color: #2e241e;
}

.book-author {
  color: #7e6253;
  font-size: 0.9rem;
  margin-bottom: 8px;
}

.book-price {
  font-weight: 700;
  font-size: 1.4rem;
  letter-spacing: -0.01em;
}

.book-genre {
  font-size: 0.8em;
  color: #888;
}

.book-card .btn-card {
  background: white;
  color: var(--orange-soft);
  border: 2px solid var(--orange-soft);
  width: 100%;
  padding: 12px 10px;
  border-radius: 40px;
  font-weight: 600;
  margin-top: auto;
  justify-content: center;
  box-shadow: none;
}

.book-card:hover .btn-card {
  background: var(--orange-soft);
  color: white;
  border-color: var(--orange-soft);
  transform: scale(1.02);
  box-shadow: 0 6px 14px rgba(245, 166, 91, 0.35);
}

.book-card .btn-card:hover {
  background: var(--orange-warm);
  border-color: var(--orange-warm);
}

.btn {
  display: inline-block;
  padding: 8px 16px;
  background: #dc8e34;
  color: white;
  text-decoration: none;
  border-radius: 4px;
  border: none;
  cursor: pointer;
}

.btn-danger {
  background: #e3342f;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.alert {
  padding: 10px;
  background: #d4edda;
  color: #155724;
  margin: 20px;
  border-radius: 4px;
}

main, .content {
    flex: 1;  /* забирает всё свободное пространство */
}

.footer {
  background: #2e241e;
  color: #f0dfd3;
  padding: 48px 0 24px;
  margin-top: auto;
  border-top: 6px solid var(--orange-soft);
}

.footer-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 36px;
  margin-bottom: 40px;
}

.footer-col h4 {
  color: var(--orange-soft);
  margin-bottom: 18px;
  font-weight: 600;
  font-size: 1.2rem;
}

.footer-col ul {
  list-style: none;
}

.footer-col li {
  margin-bottom: 12px;
}

.footer-col a {
  color: #e2cdbf;
  text-decoration: none;
  font-size: 0.95rem;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: 0.2s;
}

.footer-col a:hover {
  color: var(--orange-soft);
  transform: translateX(4px);
}

.footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 28px;
  border-top: 1px solid #5f4b3e;
  font-size: 0.9rem;
  color: #c9b2a4;
}

.social i {
  font-size: 1.4rem;
  margin-left: 16px;
  color: #e2cdbf;
  transition: 0.2s;
}

.social i:hover {
  color: var(--orange-soft);
  transform: scale(1.15);
}


/* Для мобилок */
@media (max-width: 200px) {
  .main-grid {
    flex-direction: column;
  }

  .sidebar {
    flex: auto;
    width: 100%;
  }

  .header-content {
    flex-direction: column;
    align-items: stretch;
  }

  .search-wrapper {
    max-width: 100%;
  }
}

@media (max-width: 200px) {
  .books-grid {
    grid-template-columns: 1fr;
  }

  .footer-bottom {
    flex: auto;
    gap: 16px;
  }
}


.fa-chevron-right {
  font-size: 0.7rem;
}


/* Общие стили для кнопок на обложке */
.cover-action {
  position: absolute;
  left: 8px;
  background-color: #ffffff;
  border-radius: 4px;
  padding: 4px 6px;
  color: #d67010;
  line-height: 1px;
}

.cover-action:hover {
  background: #e9801e;
  color: #ffffff;
}

/* Кнопка редактировать — сверху */
.edit-action {
  cursor: pointer;
  top: 8px;
}

/* Кнопка удалить — снизу */
.delete-action {
  bottom: 8px;
}

/* Кнопка "Купить" в состоянии "В корзине" */
.buy-btn.added {
  background-color: #ffffff;
  color: rgb(253, 165, 0);
}

/*  */
/*  */
/* для навигации снизу */
/*  */
/*  */
.pagination {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 6px;
  list-style: none;
  padding: 0;
  margin: 0;
}

/* Каждый элемент списка убираем маркеры */
.pagination li {
  list-style: none;
}

/* Общий стиль для ссылок (кружочки) */
.pagination .page-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid #e67e22;
  /* оранжевая граница */
  color: #e67e22;
  /* оранжевый текст */
  text-decoration: none;
  background: #fff;
  font-weight: 600;
  transition: all 0.2s ease;
  font-size: 0.9rem;
}

/* Активная страница (текущая) */
.pagination .page-item.active .page-link {
  background: #e67e22;
  color: #fff;
  border-color: #e67e22;
}

/* Отключённые (серые) */
.pagination .page-item.disabled .page-link {
  opacity: 0.5;
  pointer-events: none;
  color: #999;
  border-color: #ccc;
}

/* При наведении: увеличение + смена цвета */
.pagination .page-link:hover {
  background: #e67e22;
  color: #fff;
  transform: scale(1.15);
  box-shadow: 0 2px 8px rgba(230, 126, 34, 0.3);
  border-color: #e67e22;
}