@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать заказ #{{ $order->id }}</h1>
        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="delivery_status" class="form-label">Статус доставки</label>
                <select name="delivery_status" id="delivery_status" class="form-control">
                    <option value="new" {{ $order->delivery_status == 'new' ? 'selected' : '' }}>Новый заказ</option>
                    <option value="to_deliver" {{ $order->delivery_status == 'to_deliver' ? 'selected' : '' }}>К доставке</option>
                    <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Доставлено</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_status" class="form-label">Статус оплаты</label>
                <select name="payment_status" id="payment_status" class="form-control">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Ожидает оплаты</option>
                    <option value="prepaid" {{ $order->payment_status == 'prepaid' ? 'selected' : '' }}>Оплачено (предоплата)</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Оплачено</option>
                    <option value="credit" {{ $order->payment_status == 'credit' ? 'selected' : '' }}>В кредит</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
