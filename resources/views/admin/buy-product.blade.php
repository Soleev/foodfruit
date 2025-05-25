@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <h4>Пользователь: {{ $user->name }}</h4>

        <form action="{{ route('admin.users.storePurchase', $user) }}" method="POST">
            @csrf

            <div id="products-container">
                <div class="product-row mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="product_id_0" class="form-label">Выберите товар</label>
                            <select class="form-select @error('product_id.*') is-invalid @enderror" id="product_id_0"
                                    name="product_id[]" required>
                                <option value="">-- Выберите товар --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}
                                        ({{ number_format($product->price, 0, ',', ' ') }} сум)
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="quantity_0" class="form-label">Количество</label>
                            <input type="number" class="form-control @error('quantity.*') is-invalid @enderror"
                                   id="quantity_0" name="quantity[]" value="1" min="1" required>
                            @error('quantity.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-product mt-4">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-success" id="add-product">Добавить ещё товар</button>

            <button type="submit" class="btn btn-primary">Купить</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>

    <script>
        let productIndex = 0;

        document.getElementById('add-product').addEventListener('click', function () {
            productIndex++;
            const container = document.getElementById('products-container');
            const newRow = document.createElement('div');
            newRow.className = 'product-row mb-3';
            newRow.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label for="product_id_${productIndex}" class="form-label">Выберите товар</label>
                        <select class="form-select" id="product_id_${productIndex}" name="product_id[]" required>
                            <option value="">-- Выберите товар --</option>
                            @foreach ($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }} ({{ number_format($product->price, 0, ',', ' ') }} сум)</option>
                            @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="quantity_${productIndex}" class="form-label">Количество</label>
                        <input type="number" class="form-control" id="quantity_${productIndex}" name="quantity[]" value="1" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-product mt-4">Удалить</button>
                    </div>
                </div>
            `;
            container.appendChild(newRow);
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-row').remove();
            }
        });
    </script>
@endsection
