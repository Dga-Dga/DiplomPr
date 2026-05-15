@extends('layouts.base')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container my-4">
    <h2>Заказ #{{ $order->id }} от {{ $order->created_at->format('d.m.Y') }}</h2>
    <p>Статус: <span class="badge @if($order->status == 'Новый') bg-primary @elseif($order->status == 'В процессе') bg-warning text-dark @elseif($order->status == 'Завершён') bg-success @endif">{{ $order->status }}</span></p>

    <table class="table table-striped mt-3">
        <thead>
            <tr><th>Книга</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->book->title }}</td>
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
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Назад к списку</a>
</div>
@endsection