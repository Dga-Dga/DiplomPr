@extends('layouts.base')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container my-4">
    <h2>Заказ #{{ $order->id }} ({{ $order->status }})</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Пользователь: {{ $order->user->name }}</h5>
            <p>Email: {{ $order->user->email }}</p>
            <p>Дата заказа: {{ $order->created_at->format('d.m.Y H:i') }}</p>
        </div>
    </div>

    <h4>Товары в заказе</h4>
    <table class="table table-striped">
        <thead><tr><th>Книга</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr></thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    @if($item->book->image)
                        <img src="{{ asset('storage/'.$item->book->image) }}" width="40" class="me-2 rounded">
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
            <tr><td colspan="3" class="text-end fw-bold">Итого:</td><td class="fw-bold">{{ number_format($order->total_price, 0, ',', ' ') }} ₽</td></tr>
        </tfoot>
    </table>

    <div class="mt-4">
        <h5>Изменить статус</h5>
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="row g-2 align-items-center">
            @csrf
            @method('PATCH')
            <div class="col-auto">
                <select name="status" class="form-select">
                    @foreach(['Новый', 'В процессе', 'Завершён'] as $st)
                        <option value="{{ $st }}" @if($order->status == $st) selected @endif>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary mt-3">Назад к списку</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection