@extends('books.layout')

@include('layouts.base')

    <style>
/* === Управление заказами – упрощённый оранжевый стиль === */
.orders-container {
    max-width: 1100px;
    margin: 2rem auto;
    padding: 0 1rem;
    font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
    color: #333;
}

/* Заголовок */
.orders-container h2 {
    margin-bottom: 1.5rem;
    font-size: 1.7rem;
    font-weight: 600;
    color: #e67e22;          /* оранжевый акцент */
}

/* Фильтр */
.orders-container .filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    background: #fff5ec;      /* очень светлый оранжевый */
    padding: 0.75rem 1rem;
    border-radius: 6px;
}

.orders-container .filter-select {
    padding: 0.4rem 0.8rem;
    border: 1px solid #f5cba7;
    border-radius: 4px;
    font-size: 0.9rem;
    outline: none;
    background: white;
    min-width: 180px;
}

.orders-container .filter-btn {
    padding: 0.4rem 1.2rem;
    background: #f0a04b;      /* светло-оранжевая кнопка */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.9rem;
    transition: background 0.2s;
}

.orders-container .filter-btn:hover {
    background: #e08e3a;
}

/* Таблица */
.orders-container .table-wrapper {
    overflow-x: auto;
    border: 1px solid #fde3ce;
    border-radius: 6px;
    background: white;
}

.orders-container .orders-table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
}

.orders-container .orders-table th {
    background: #fff3e6;       /* нежный оранжевый фон шапки */
    font-weight: 600;
    color: #92400e;
    padding: 0.75rem 1rem;
    border-bottom: 2px solid #f5cba7;
}

.orders-container .orders-table td {
    padding: 0.7rem 1rem;
    border-bottom: 1px solid #fbe8d8;
    color: #444;
}

.orders-container .orders-table tbody tr:hover td {
    background: #fff8f2;       /* лёгкий оранжевый оттенок при наведении */
}

/* Бейджи статусов */
.orders-container .status-badge {
    display: inline-block;
    padding: 0.2em 0.7em;
    border-radius: 12px;
    font-size: 0.78rem;
    font-weight: 600;
    background: #fef0e1;
    color: #b45309;
}

.orders-container .status-badge.status-new {
    background: #ffedd5;
    color: #c2410c;
}

.orders-container .status-badge.status-progress {
    background: #fff3cd;
    color: #b45309;
}

.orders-container .status-badge.status-done {
    background: #e9f5e1;
    color: #2d6a4f;
}

/* Кнопки действий */
.orders-container .btn-sm {
    display: inline-block;
    padding: 0.3rem 0.7rem;
    border: 1px solid #f5cba7;
    background: white;
    border-radius: 4px;
    font-size: 0.8rem;
    color: #b45309;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
}

.orders-container .btn-sm:hover {
    background: #fff3e6;
    border-color: #f0a04b;
    color: #92400e;
}

/* Дропдаун (простой) */
.orders-container .dropdown-wrapper {
    position: relative;
    display: inline-block;
}

.orders-container .dropdown-toggle::after {
    content: ' ▾';
    font-size: 0.65rem;
}

.orders-container .dropdown-menu {
    position: absolute;
    right: 0;
    top: 100%;
    margin-top: 4px;
    background: white;
    border: 1px solid #f5cba7;
    border-radius: 4px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    min-width: 150px;
    display: none;
    z-index: 20;
    padding: 0.25rem 0;
}

.orders-container .dropdown-menu.show {
    display: block;
}

.orders-container .dropdown-item-btn {
    display: block;
    width: 100%;
    padding: 0.4rem 1rem;
    border: none;
    background: none;
    text-align: left;
    font-size: 0.85rem;
    color: #b45309;
    cursor: pointer;
}

.orders-container .dropdown-item-btn:hover {
    background: #fff5ec;
}

/* Пагинация */
.orders-container .pagination {
    display: flex;
    justify-content: center;
    gap: 3px;
    margin-top: 1.5rem;
    list-style: none;
    padding: 0;
}

.orders-container .pagination li a,
.orders-container .pagination li span {
    display: inline-block;
    padding: 0.3rem 0.7rem;
    border: 1px solid #fde3ce;
    border-radius: 4px;
    color: #b45309;
    text-decoration: none;
    font-size: 0.9rem;
    background: white;
}

.orders-container .pagination li.active span {
    background: #f0a04b;
    color: white;
    border-color: #f0a04b;
}

.orders-container .pagination li a:hover {
    background: #fff3e6;
}
    </style>

@section('content')
<div class="orders-container">
    <h2><i class="fas fa-clipboard-list"></i> Управление заказами</h2>

    <form method="GET" class="filter-form">
        <select name="status" class="filter-select">
            <option value="">Все статусы</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" @if(request('status') == $status) selected @endif>{{ $status }}</option>
            @endforeach
        </select>
        <button type="submit" class="filter-btn">Фильтр</button>
    </form>

    <div class="table-wrapper">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Номер</th>
                    <th>Пользователь</th>
                    <th>Email</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', ' ') }} ₽</td>
                    <td>
                        <span class="status-badge 
                            @if($order->status == 'Новый') status-new 
                            @elseif($order->status == 'В процессе') status-progress 
                            @elseif($order->status == 'Завершён') status-done 
                            @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <div class="actions-group">
                            <button class="kn">
                            <a href="{{ route('admin.orders.show', $order) }}">Просмотр</a>
                            </button>
                            <div class="dropdown-wrapper">
                                <button type="button" class="btn-sm dropdown-toggle" onclick="toggleDropdown(this)">Сменить статус</button>
                                <div class="dropdown-menu">
                                    @foreach(['Новый', 'В процессе', 'Завершён'] as $st)
                                        @if($order->status !== $st)
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $st }}">
                                            <button type="submit" class="dropdown-item-btn">{{ $st }}</button>
                                        </form>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
</div>

<script>
    function toggleDropdown(btn) {
        const dropdown = btn.nextElementSibling;
        const isOpen = dropdown.classList.contains('show');
        
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));
        if (!isOpen) {
            dropdown.classList.add('show');
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-wrapper')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));
        }
    });
</script>
@endsection