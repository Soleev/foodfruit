@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список заказов</h1>
        <div class="mb-3">
            <a href="{{ route('admin.orders.printAll') }}" target="_blank" class="btn btn-secondary">Печать всех заказов
                для доставки <span class="badge badge-light">( {{ $toDeliverCount ?? 0 }} )</span></a>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Дата заказа</th>
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
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $order->user->name ?? 'Неизвестный' }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach ($order->products as $product)
                                <li>
                                    {{ $product->name }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
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
                    <td>
                        <p>Сумма без скидки: {{ number_format($order->original_total_price, 0, ',', ' ') }} сум</p>
                        <p>Скидка: {{ $order->applied_discount_percentage ?? 0 }}%</p>
                        <p>Сумма со скидкой: {{ number_format($order->total_price, 0, ',', ' ') }} сум</p>
                    </td>

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
                        <ul class="list-group">
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="list-group-item list-group-item-action list-group-item-primary">Изменить</a>

                            @if($order->delivery_status == 'to_deliver')
                                <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank"
                                   class="list-group-item list-group-item-action list-group-item-dark">Печать</a>
                            @endif

                            <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="list-group-item list-group-item-action list-group-item-danger"
                                        onclick="return confirm('Удалить заказ?')">Удалить
                                </button>
                            </form>

                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
