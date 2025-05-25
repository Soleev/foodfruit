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
            page-break-inside: avoid; /* Предотвращает разрыв заказа на разных страницах при печати */
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
        .signature {
            margin-top: 10px;
            font-style: italic;
        }
        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
            .order {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body onload="window.print()">
<h1 class="no-print">Заказы для доставки</h1>
<p>Дата: {{ now()->format('d.m.Y H:i') }}</p>
@forelse($orders as $order)
    <div class="order">
        <h2>Заказ #{{ $order->id }}</h2>
        <p>
            <strong>Покупатель:</strong> {{ $order->user->name ?? 'Неизвестный' }}
            <strong>Магазин:</strong> {{ $order->user->store_name ?? 'Неизвестный' }}
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
                <th>Скидка</th>
                <th>Сумма со скидкой</th>
            </tr>
            </thead>
            <tbody>
            @php
                $discountPercentage = $order->applied_discount_percentage ?? 0;
                $originalTotal = $order->products->sum(function ($product) {
                    return $product->price * $product->pivot->quantity;
                });
                $discountedTotal = $order->total_price;
            @endphp
            @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }} шт.</td>
                    <td>{{ number_format($product->price, 0, ',', ' ') }} сум</td>
                    <td>{{ number_format($product->price * $product->pivot->quantity, 0, ',', ' ') }} сум</td>
                    <td>{{ number_format($discountPercentage, 0) }}%</td>
                    <td>
                        {{ number_format(
                            $product->price * $product->pivot->quantity * (1 - ($discountPercentage / 100)),
                            0, ',', ' '
                        ) }} сум
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p><strong>Итого без скидки:</strong> {{ number_format($originalTotal, 0, ',', ' ') }} сум</p>
        <p><strong>Скидка:</strong> {{ number_format($discountPercentage, 0) }}%</p>
        <p><strong>Итого со скидкой:</strong> {{ number_format($discountedTotal, 0, ',', ' ') }} сум</p>
        <p><strong>Статус оплаты:</strong>
            {{ $order->payment_status == 'pending' ? 'Ожидает оплаты' :
               ($order->payment_status == 'prepaid' ? 'Оплачено (предоплата)' :
               ($order->payment_status == 'paid' ? 'Оплачено' :
               ($order->payment_status == 'credit' ? 'В кредит' : 'Неизвестно'))) }}
        </p>
        <p class="signature">Товар принял: _____________________ (подпись клиента)</p>
    </div>
@empty
    <p>Нет заказов для доставки.</p>
@endforelse
<div class="no-print">
    <a href="{{ route('admin.orders') }}">Вернуться назад</a>
</div>
</body>
</html>
