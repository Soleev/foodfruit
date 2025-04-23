@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Управление скидками</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.discounts.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="user_id" class="form-label">Пользователь</label>
                    <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                        <option value="">Выберите пользователя</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="product_id" class="form-label">Товар</label>
                    <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                        <option value="">Выберите товар</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ ucfirst($product->category) }})</option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="discount_percentage" class="form-label">Скидка (%)</label>
                    <input type="number" step="0.01" class="form-control @error('discount_percentage') is-invalid @enderror" id="discount_percentage" name="discount_percentage" required>
                    @error('discount_percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Установить скидку</button>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Товар</th>
                <th>Скидка (%)</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($discounts as $discount)
                <tr>
                    <td>{{ $discount->user->name }} ({{ $discount->user->email }})</td>
                    <td>{{ $discount->product->name }} ({{ ucfirst($discount->product->category) }})</td>
                    <td>{{ $discount->discount_percentage }}%</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
