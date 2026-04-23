<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ЛитБук — книжный магазин</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="header">
  <div class="container header-content">
    <a href="#" class="logo">
      <i class="fas fa-book-open"></i>
      <span>ЛитБук</span>
    </a>

    <!-- Панель поиска (глобальная) -->
    <div class="search-wrapper">
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Поиск по книгам, авторам...">
        <button><i class="fas fa-arrow-right"></i> Найти</button>
      </div>
    </div>

    <div class="header-actions">
    <a href="{{ route('books.create') }}" class= "btn btn-card"> Добавить книгу</a>
      <a href="#"><i class="far fa-heart"></i></a>
      <a href="#"><i class="far fa-user-circle"></i></a>
      <a href="#"><i class="fas fa-shopping-bag"></i></a>
    </div>
  </div>
</header>
</body>
</html>