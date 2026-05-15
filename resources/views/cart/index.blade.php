@extends('layouts.base')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container my-4">
    <h2 class="mb-4"><i class="fas fa-shopping-bag" style="color: var(--orange-soft);"></i> Корзина</h2>

    @if($cartItems->isEmpty())
        <p>Ваша корзина пуста. <a href="{{ route('books.index') }}">Перейти к покупкам</a></p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
                            <div class="d-flex align-items-center">
                                @if($item->book->image)
                                    <img src="{{ asset('storage/' . $item->book->image) }}" width="50" class="me-3 rounded" alt="{{ $item->book->title }}">
                                @endif
                                <span>{{ $item->book->title }}</span>
                            </div>
                        </td>
                        <td>{{ number_format($item->book->price, 0, ',', ' ') }} ₽</td>
                        <td style="width: 100px;">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm" style="width: 70px;" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>{{ number_format($item->book->price * $item->quantity, 0, ',', ' ') }} ₽</td>
                        <td>
                            <form action="{{ route('cart.destroy', $item) }}" method="POST" onsubmit="return confirm('Удалить книгу из корзины?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Итого:</td>
                        <td class="fw-bold">{{ number_format($total, 0, ',', ' ') }} ₽</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Продолжить покупки</a>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg">Оформить заказ</button>
            </form>
        </div>
    @endif
</div>
@endsection