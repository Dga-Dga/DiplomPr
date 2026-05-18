<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ЛитБук — книжный магазин</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">


  @section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  @endsection


  {{-- Мои иконки для сайта --}}
  {{-- fas (Solid)
  far (Regular)
  fab (разные бренды, тг, инста и тд) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('styles')
</head>

<body>
  <header class="header">
    <div class="container header-content">
      <a href="{{ route('books.index') }}" class="logo">
        <i class="fas fa-book-open"></i>
        <span>ЛитБук</span>
      </a>

      <!-- Поиск (по названию книги) -->
      <div class="search-wrapper">
        <form method="GET" action="{{ route('books.index') }}">
          <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="search" name="search" placeholder="Название книги..." value="{{ request('search') }}">
            <button><i class="fas fa-arrow-right"></i> Найти</button>
          </div>
          <!-- Скрытый инпут, чтобы при поиске не сбрасывался выбранный жанр (если он есть) -->
          @if(request('genre'))

            <input type="hidden" name="genre" value="{{ request('genre') }}">

          @endif

          <button type="submit" style="display: none;"></button>
        </form>

      </div>
      {{-- Вывод имени и роли пользователя --}}
      <div class="header-actions">

        @auth

          @if(auth()->user()->isAdmin())

            <a href="{{ route('admin.dashboard') }}" class="btn btn-card">
              <p>Добро пожаловать, Администратор!</p>
            </a>

          @elseif(auth()->user()->isManager())

            <a href="{{ route('manager.dashboard') }}" class="btn btn-card">
              <p>Добро пожаловать, Менеджер!</p>
            </a>
          @else

            <p>Добро пожаловать, {{ auth()->user()->name }}!</p>

          @endif

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="btn btn-card">
              <button type="submit">Выйти</button>
            </a>
          </form>

        @endauth
        {{-- @auth
        <p>Привет, {{ auth()->user()->name }}</p>
        <p>Роль: {{ auth()->user()->role }}</p>
        @endauth --}}

        @guest
          <a href="{{ route('login') }}" class="btn btn-card">Войти</a>
          <a href="{{ route('register') }}" class="btn btn-card">Зарегистрироваться</a>
        @endguest

        @auth
          @if(auth()->user()->isAdmin() || auth()->user()->isManager())
            <a href="{{ route('books.create') }}" class="btn btn-card"> Добавить книгу</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-card">Управление заказами</a>
          @endif
          <a href="{{ route('orders.index') }}" class="btn btn-card">Мои заказы</a>
        @endauth

        <a href="{{ route('favorites.index') }}" title="Избранное" style="position: relative;">
          <i class="far fa-heart"></i>
          @auth
            <span class="favorites-count">{{ auth()->user()->favorites()->count() }}</span>
          @endauth
        </a>

        
        <a href="{{ route('cart.index') }}" style="position: relative;" title="Корзина">
          <i class="fa fa-shopping-bag"></i>
          @auth
          <span class="cart-count badge bg-warning text-dark"
          style="position: absolute; top: -5px; right: -5px; font-size: 0.7rem; min-width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
          {{ Auth::user()->cartItems()->sum('quantity') }}
        </span>
        @endauth
      </a>
      <a href="{{ route('books.index') }}"><i class="far fa-user-circle"></i></a>

      </div>
    </div>
  </header>
  @include('includes.scroll')
  @yield('content')
</body>
</html>