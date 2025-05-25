<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Печать заказов для доставки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .order {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .order h2 {
            margin: 0 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
<h1>Заказы для доставки</h1>
<p>Дата: {{ now()->format('d.m.Y H:i') }}</p>
@forelse($orders as $order)
    <div class="order">
        <h2>Заказ #{{ $order->id }}</h2>
        <p>
            <strong>Пользователь:</strong> {{ $order->user->name ?? 'Неизвестный' }}
            <strong>Адрес:</strong> {{ $order->user->address ?? 'Не указан' }}
            <strong>Телефон:</strong> {{ $order->user->phone ?? 'Не указан' }}
            <strong>Дата заказа:</strong> {{ $order->created_at->format('d.m.Y H:i') }}
        </p>
        <table>
            <thead>
            <tr>
                <th>Товар</th>
                <th>Количество</th>
                <th>Цена за единицу</th>
                <th>Общая стоимость</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }} шт.</td>
                    <td>{{ number_format($product->price, 0, ',', ' ') }} сум</td>
                    <td>{{ number_format($product->price * $product->pivot->quantity, 0, ',', ' ') }} сум</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p><strong>Итого:</strong> {{ number_format($order->total_price, 0, ',', ' ') }} сум</p>
        <p><strong>Статус оплаты:</strong>
            {{ $order->payment_status == 'pending' ? 'Ожидает оплаты' :
               ($order->payment_status == 'prepaid' ? 'Оплачено (предоплата)' :
               ($order->payment_status == 'paid' ? 'Оплачено' :
               ($order->payment_status == 'credit' ? 'В кредит' : 'Неизвестно'))) }}
            , Товар принял_____________
        </p>
    </div>
@empty
    <p>Нет заказов для доставки.</p>
@endforelse
<div class="no-print">
    <a href="{{ route('admin.orders') }}">Вернуться назад</a>
</div>
</body>
</html>
