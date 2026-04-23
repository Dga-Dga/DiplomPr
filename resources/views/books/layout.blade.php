<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Книжный магазин</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .book-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .book-cover {
            height: 150px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            border-radius: 4px;
            overflow: hidden;
        }

        .book-cover {
            height: 200px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            border-radius: 4px;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* .book-cover img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .book-cover i {
            font-size: 48px;
            color: #aaa;
        } */
        .book-title {
            font-weight: bold;
            margin: 5px 0;
        }

        .book-author {
            color: #666;
            font-size: 0.9em;
        }

        .book-price {
            font-size: 1.2em;
            color: #2c3e50;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #3490dc;
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
    </style>
</head>

<body>
    <div class="container">
        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>

</html>