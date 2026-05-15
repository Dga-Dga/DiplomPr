@extends('layouts.base')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid my-4">
    <h2><i class="fas fa-clipboard-list"></i> Управление заказами</h2>

    <form method="GET" class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <select name="status" class="form-select">
                <option value="">Все статусы</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @if(request('status') == $status) selected @endif>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Фильтр</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
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
                        <span class="badge @if($order->status == 'Новый') bg-primary @elseif($order->status == 'В процессе') bg-warning text-dark @elseif($order->status == 'Завершён') bg-success @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary">Просмотр</a>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                Сменить статус
                            </button>
                            <ul class="dropdown-menu">
                                @foreach(['Новый', 'В процессе', 'Завершён'] as $st)
                                    @if($order->status !== $st)
                                    <li>
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $st }}">
                                            <button type="submit" class="dropdown-item">{{ $st }}</button>
                                        </form>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>

<!-- Bootstrap JS (нужен для dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection