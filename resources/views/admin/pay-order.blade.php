@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <p>Пользователь: {{ $user->name }}</p>
        <p>Сумма заказа: {{ number_format($order->total_price, 0, ',', ' ') }} сум</p>
        <p>Оплачено: {{ number_format($order->total_price - $order->remaining_debt, 0, ',', ' ') }} сум</p>
        <p>Остаток долга: {{ number_format($order->remaining_debt, 0, ',', ' ') }} сум</p>

        @if($order->remaining_debt > 0)
            <form action="{{ route('admin.orders.storePayment', [$user, $order]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="amount" class="form-label">Сумма платежа</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" min="0" max="{{ $order->remaining_debt }}" required>
                    @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Метод оплаты</label>
                    <input type="text" class="form-control" id="payment_method" name="payment_method" placeholder="Например: наличные, карта">
                </div>
                <button type="submit" class="btn btn-primary">Внести платеж</button>
            </form>
        @else
            <p class="text-success">Заказ полностью оплачен.</p>
        @endif

        <a href="{{ route('admin.users.orders', $user) }}" class="btn btn-secondary mt-3">Назад</a>
    </div>
@endsection
