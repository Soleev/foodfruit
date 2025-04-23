@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Личный кабинет, {{ auth()->user()->name }}!</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text">
                                    Цена:
                                    @if(isset($discounts[$product->id]))
                                        <span class="text-danger">{{ number_format($product->price * (1 - $discounts[$product->id]->discount_percentage / 100), 0, ',', ' ') }} сум</span>
                                        <small class="text-muted">(Скидка: {{ $discounts[$product->id]->discount_percentage }}%)</small>
                                    @else
                                        {{ number_format($product->price, 0, ',', ' ') }} сум
                                    @endif
                                </p>
                                <div class="input-group">
                                    <span class="input-group-text">Количество:</span>
                                    <input type="number" class="form-control @error('quantities.' . $product->id) is-invalid @enderror"
                                           name="quantities[{{ $product->id }}]" value="0" min="0">
                                    @error('quantities.' . $product->id)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mt-3">Оформить заказ</button>
        </form>
    </div>
@endsection
