@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Управление скидками по сумме заказа</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.discounts.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="threshold_amount" class="form-label">Пороговая сумма (сум)</label>
                    <input type="number" step="0.01" class="form-control @error('threshold_amount') is-invalid @enderror" id="threshold_amount" name="threshold_amount" required>
                    @error('threshold_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="discount_percentage" class="form-label">Скидка (%)</label>
                    <input type="number" step="0.01" class="form-control @error('discount_percentage') is-invalid @enderror" id="discount_percentage" name="discount_percentage" required>
                    @error('discount_percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Добавить скидку</button>
        </form>

        <h2 class="mb-3">Текущие скидки</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Пороговая сумма</th>
                <th>Скидка (%)</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($discountTiers as $discount)
                <tr>
                    <td>{{ $discount->id }}</td>
                    <td>{{ number_format($discount->threshold_amount, 0, ',', ' ') }} сум</td>
                    <td>{{ $discount->discount_percentage }}%</td>
                    <td>
                        <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-sm btn-primary">Изменить</a>
                        <form action="{{ route('admin.discounts.delete', $discount->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить скидку?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Скидок пока нет.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <h2 class="mb-3">История изменений скидок</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Дата</th>
                <th>Действие</th>
                <th>Пороговая сумма</th>
                <th>Скидка (%)</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($discountHistory as $history)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($history->action_at)->format('d.m.Y H:i') }}</td>
                    <td>
                        {{ $history->action == 'created' ? 'Создано' :
                           ($history->action == 'updated' ? 'Обновлено' : 'Удалено') }}
                    </td>
                    <td>{{ number_format($history->threshold_amount, 0, ',', ' ') }} сум</td>
                    <td>{{ $history->discount_percentage }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">История изменений пуста.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
