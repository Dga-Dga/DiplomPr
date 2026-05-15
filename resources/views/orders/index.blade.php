@extends('layouts.base')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container my-4">
    <h2 class="mb-4"><i class="fas fa-receipt" style="color: var(--orange-soft);"></i> Мои заказы</h2>

    @if($orders->isEmpty())
        <p>У вас пока нет заказов.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Дата</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', ' ') }} ₽</td>
                        <td>
                            <span class="badge @if($order->status == 'Новый') bg-primary @elseif($order->status == 'В процессе') bg-warning text-dark @elseif($order->status == 'Завершён') bg-success @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Подробнее</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    @endif
</div>
@endsection