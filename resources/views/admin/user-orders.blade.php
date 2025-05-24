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
                            <th>Товар</th>
                            <th>Количество</th>
                            <th>Цена за единицу</th>
                            <th>Общая стоимость</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ number_format($product->price, 0, ',', ' ') }} сум</td>
                                <td>{{ number_format($product->price * $product->pivot->quantity, 0, ',', ' ') }} сум</td>
                            </tr>
                        @endforeach
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
