@extends('books.layout')
@include('layouts.base')

@section('content')
<div class="cart-container">
    <h2><i class="fas fa-shopping-bag" style="color: #e67e22;"></i> Корзина</h2>

    @if($cartItems->isEmpty())
        <p class="empty-cart">Ваша корзина пуста. <a href="{{ route('books.index') }}">Перейти к покупкам</a></p>
    @else
        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Книга</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
                        <th>Сумма</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                @if($item->book->image)
                                    <img src="{{ asset('storage/' . $item->book->image) }}" class="cart-thumb" alt="{{ $item->book->title }}">
                                @endif
                                <span>{{ $item->book->title }}</span>
                            </div>
                        </td>
                        <td>{{ number_format($item->book->price, 0, ',', ' ') }} ₽</td>
                        <td>
                            <form action="{{ route('cart.update', $item) }}" method="POST" style="display: flex;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-input" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>{{ number_format($item->book->price * $item->quantity, 0, ',', ' ') }} ₽</td>
                        <td>
                            <form action="{{ route('cart.destroy', $item) }}" method="POST" onsubmit="return confirm('Удалить книгу из корзины?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-remove"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: 600;">Итого:</td>
                        <td style="font-weight: 600;">{{ number_format($total, 0, ',', ' ') }} ₽</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="cart-actions">
            <a href="{{ route('books.index') }}" class="btn btn-outline-orange">Продолжить покупки</a>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-orange">Оформить заказ</button>
            </form>
        </div>
    @endif
</div>
@endsection


<style>
    /* === Корзина – оранжевый стиль === */
.cart-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 0 1rem;
    font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
    color: #333;
}

/* Заголовок */
.cart-container h2 {
    font-size: 1.7rem;
    font-weight: 600;
    color: #e67e22;
    margin-bottom: 1.5rem;
}

/* Пустая корзина */
.cart-container .empty-cart {
    font-size: 1rem;
    color: #666;
}

.cart-container .empty-cart a {
    color: #b45309;
    text-decoration: underline;
}

/* Таблица */
.cart-container .cart-table-wrapper {
    overflow-x: auto;
    border: 1px solid #fde3ce;
    border-radius: 6px;
    background: white;
}

.cart-container .cart-table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
}

.cart-container .cart-table th {
    background: #fff3e6;
    font-weight: 600;
    color: #92400e;
    padding: 0.75rem 1rem;
    border-bottom: 2px solid #f5cba7;
    font-size: 0.9rem;
}

.cart-container .cart-table td {
    padding: 0.7rem 1rem;
    border-bottom: 1px solid #fbe8d8;
    color: #444;
    font-size: 0.95rem;
    vertical-align: middle;
}

.cart-container .cart-table tbody tr:hover td {
    background: #fff8f2;
}

/* Итоговая строка */
.cart-container .cart-table tfoot td {
    font-weight: 600;
    color: #92400e;
    background: #fffaf5;
}

/* Миниатюра книги */
.cart-container .cart-thumb {
    width: 50px;
    height: auto;
    border-radius: 4px;
    margin-right: 10px;
    vertical-align: middle;
}

/* Поле количества */
.cart-container .qty-input {
    width: 70px;
    padding: 0.3rem 0.4rem;
    border: 1px solid #f5cba7;
    border-radius: 4px;
    font-size: 0.9rem;
    text-align: center;
    outline: none;
}

.cart-container .qty-input:focus {
    border-color: #f0a04b;
    box-shadow: 0 0 0 2px rgba(240,160,75,0.15);
}

/* Кнопка удаления (иконка) */
.cart-container .btn-remove {
    background: none;
    border: 1px solid #f5cba7;
    color: #c2410c;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.15s;
}

.cart-container .btn-remove:hover {
    background: #fff3e6;
    border-color: #f0a04b;
    color: #b45309;
}

/* Блок с действиями внизу */
.cart-container .cart-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

/* Кнопки */
.cart-container .btn {
    display: inline-block;
    padding: 0.5rem 1.2rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.95rem;
    text-decoration: none;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.15s;
    text-align: center;
}

/* Продолжить покупки (outline) */
.cart-container .btn-outline-orange {
    background: white;
    color: #b45309;
    border: 1px solid #f5cba7;
}

.cart-container .btn-outline-orange:hover {
    background: #fff3e6;
    border-color: #f0a04b;
    color: #92400e;
}

/* Оформить заказ (основная) */
.cart-container .btn-orange {
    background: #f0a04b;
    color: white;
    border: none;
    font-size: 1rem;
    padding: 0.65rem 2rem;
}

.cart-container .btn-orange:hover {
    background: #e08e3a;
}
</style>