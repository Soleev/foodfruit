@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список заказов</h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Товар</th>
                <th>Количество-цена</th>
                <th>Сумма</th>
                <th>Статус доставки</th>
                <th>Статус оплаты</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Неизвестный' }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach ($order->products as $product)
                                <li>
                                    {{ $product->name }} —
                                </li>
                            @endforeach
                        </ul>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach ($order->products as $product)
                                <li>
                                    {{ $product->pivot->quantity }} шт. —
                                    {{ number_format($product->price, 0, ',', ' ') }} сум
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    </td>
                    {{--<td>{{ $order->product->name ?? 'Неизвестный' }}</td>--}}
                    {{--<td>{{ $order->quantity ?? 'Неизвестный' }}</td>--}}
                    <td>{{ number_format($order->total_price, 0, ',', ' ') }} сум</td>
                    <td>
    <span class="badge
        {{ $order->delivery_status == 'new' ? 'bg-primary' :
           ($order->delivery_status == 'to_deliver' ? 'bg-warning' :
           ($order->delivery_status == 'delivered' ? 'bg-success' : 'bg-secondary')) }}">
        {{ $order->delivery_status == 'new' ? 'Новый заказ' :
           ($order->delivery_status == 'to_deliver' ? 'К доставке' :
           ($order->delivery_status == 'delivered' ? 'Доставлено' : 'Неизвестно')) }}
    </span>
                    </td>
                    <td>
    <span class="badge
        {{ $order->payment_status == 'pending' ? 'bg-warning' :
           ($order->payment_status == 'prepaid' ? 'bg-info' :
           ($order->payment_status == 'paid' ? 'bg-success' :
           ($order->payment_status == 'credit' ? 'bg-danger' : 'bg-secondary'))) }}">
        {{ $order->payment_status == 'pending' ? 'Ожидает оплаты' :
           ($order->payment_status == 'prepaid' ? 'Оплачено (предоплата)' :
           ($order->payment_status == 'paid' ? 'Оплачено' :
           ($order->payment_status == 'credit' ? 'В кредит' : 'Неизвестно'))) }}
    </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                           class="btn btn-sm btn-primary">Изменить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
