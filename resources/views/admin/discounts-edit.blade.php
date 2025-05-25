@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Редактировать скидку</h1>

        <form action="{{ route('admin.discounts.update', $discountTier->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="threshold_amount" class="form-label">Пороговая сумма (сум)</label>
                    <input type="number" step="0.01" class="form-control @error('threshold_amount') is-invalid @enderror" id="threshold_amount" name="threshold_amount" value="{{ $discountTier->threshold_amount }}" required>
                    @error('threshold_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="discount_percentage" class="form-label">Скидка (%)</label>
                    <input type="number" step="0.01" class="form-control @error('discount_percentage') is-invalid @enderror" id="discount_percentage" name="discount_percentage" value="{{ $discountTier->discount_percentage }}" required>
                    @error('discount_percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Обновить скидку</button>
            <a href="{{ route('admin.discounts') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
