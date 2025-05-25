@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>

        @forelse ($orders as $order)
            <div class="card mb-3">
                <div class="card-header">
                    Заказ #{{ $order->id }} от {{ $order->created_at->format('d.m.Y H:i') }}
                    ({{ $order->delivery_status == 'new' ? 'Новый заказ' :
                               ($order->delivery_status == 'to_deliver' ? 'К доставке' :
                               ($order->delivery_status == 'delivered' ? 'Доставлено' : 'Неизвестно')) }})
                    ({{ $order->payment_status == 'pending' ? 'Ожидает оплаты' :
                               ($order->payment_status == 'prepaid' ? 'Оплачено (предоплата)' :
                               ($order->payment_status == 'paid' ? 'Оплачено' :
                               ($order->payment_status == 'credit' ? 'В кредит' : 'Неизвестно'))) }})
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата</th>
                            <th>Товары</th>
                            <th>Сумма</th>
                            <th>Статус доставки</th>
                            <th>Статус оплаты</th>
                            <th>Действия</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <ul>
                                        @foreach($order->products as $product)
                                            <li>{{ $product->name }} ({{ $product->pivot->quantity }} шт.)</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <p>Сумма: {{ number_format($order->total_price, 0, ',', ' ') }} сум</p>
                                    <p>Оплачено: {{ number_format($order->total_price - $order->remaining_debt, 0, ',', ' ') }} сум</p>
                                    <p>Остаток: {{ number_format($order->remaining_debt, 0, ',', ' ') }} сум</p>
                                </td>
                                <td>{{ $order->delivery_status }}</td>
                                <td>{{ $order->payment_status }}</td>
                                <td>
                                    @if($order->remaining_debt > 0)
                                        <a href="{{ route('admin.orders.pay', [$user, $order]) }}" class="btn btn-sm btn-success">Оплатить</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Заказов пока нет.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <p><strong>Итого:</strong> {{ number_format($order->total_price, 0, ',', ' ') }} сум</p>
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary">Изменить</a>
                </div>
            </div>
        @empty
            <p>Покупок пока нет.</p>
        @endforelse

        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection
