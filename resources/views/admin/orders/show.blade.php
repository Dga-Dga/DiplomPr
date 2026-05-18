@extends('books.layout')

@include('layouts.base')


@section('content')
    <div class="order-detail-container">
        <h2>Заказ #{{ $order->id }} ({{ $order->status }})</h2>

        <div class="info-card">
            <h3>{{ $order->user->name }}</h3>
            <p>Email: {{ $order->user->email }}</p>
            <p>Дата заказа: {{ $order->created_at->format('d.m.Y H:i') }}</p>
        </div>

        <h4>Товары в заказе</h4>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Книга</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            @if($item->book->image)
                                <img src="{{ asset('storage/' . $item->book->image) }}" class="book-thumb" alt="Обложка">
                            @endif
                            {{ $item->book->title }}
                        </td>
                        <td>{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Итого:</td>
                    <td>{{ number_format($order->total_price, 0, ',', ' ') }} ₽</td>
                </tr>
            </tfoot>
        </table>

        <h5 style="font-weight: 600; color: #92400e; margin-bottom: 0.5rem;">Изменить статус</h5>
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="status-form">
            @csrf
            @method('PATCH')
            <select name="status" class="status-select">
                @foreach(['Новый', 'В процессе', 'Завершён'] as $st)
                    <option value="{{ $st }}" @if($order->status == $st) selected @endif>{{ $st }}</option>
                @endforeach
            </select>
            <button type="submit" class="status-btn">Обновить</button>
        </form>

        <a href="{{ route('admin.orders.index') }}" class="back-link">← Назад к списку</a>
    </div>
@endsection


<style>
    .order-detail-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
        color: #333;
    }

    /* Заголовок */
    .order-detail-container h2 {
        font-size: 1.7rem;
        font-weight: 600;
        color: #e67e22;
        /* оранжевый акцент */
        margin-bottom: 1.5rem;
    }

    /* Карточка пользователя */
    .order-detail-container .info-card {
        background: #fff5ec;
        border: 1px solid #fde3ce;
        border-radius: 8px;
        padding: 1.2rem 1.5rem;
        margin-bottom: 2rem;
    }

    .order-detail-container .info-card h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0 0 0.8rem 0;
        color: #92400e;
    }

    .order-detail-container .info-card p {
        margin: 0.4rem 0;
        font-size: 0.95rem;
        color: #555;
    }

    /* Заголовок раздела товаров */
    .order-detail-container h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #b45309;
        margin: 2rem 0 1rem;
    }

    /* Таблица товаров */
    .order-detail-container .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
        border: 1px solid #fde3ce;
        border-radius: 6px;
        overflow: hidden;
    }

    .order-detail-container .items-table th {
        background: #fff3e6;
        font-weight: 600;
        color: #92400e;
        padding: 0.75rem 1rem;
        border-bottom: 2px solid #f5cba7;
        font-size: 0.9rem;
    }

    .order-detail-container .items-table td {
        padding: 0.7rem 1rem;
        border-bottom: 1px solid #fbe8d8;
        color: #444;
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .order-detail-container .items-table tbody tr:hover td {
        background: #fff8f2;
    }

    /* Итоговая строка */
    .order-detail-container .items-table tfoot td {
        font-weight: 600;
        color: #92400e;
        background: #fffaf5;
    }

    /* Миниатюра книги */
    .order-detail-container .book-thumb {
        width: 40px;
        height: auto;
        border-radius: 4px;
        margin-right: 10px;
        vertical-align: middle;
    }

    /* Форма изменения статуса */
    .order-detail-container .status-form {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
        background: #fff5ec;
        padding: 1rem;
        border-radius: 6px;
        margin: 1.5rem 0;
    }

    .order-detail-container .status-select {
        padding: 0.4rem 0.8rem;
        border: 1px solid #f5cba7;
        border-radius: 4px;
        font-size: 0.9rem;
        background: white;
        min-width: 180px;
        outline: none;
    }

    .order-detail-container .status-btn {
        padding: 0.4rem 1.2rem;
        background: #f0a04b;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        font-size: 0.9rem;
        transition: background 0.2s;
    }

    .order-detail-container .status-btn:hover {
        background: #e08e3a;
    }

    /* Кнопка "Назад" */
    .order-detail-container .back-link {
        display: inline-block;
        padding: 0.4rem 1rem;
        border: 1px solid #f5cba7;
        border-radius: 4px;
        color: #b45309;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.15s;
        margin-top: 0.5rem;
    }

    .order-detail-container .back-link:hover {
        background: #fff3e6;
        border-color: #f0a04b;
        color: #92400e;
    }
</style>