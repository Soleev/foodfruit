@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Каталог: {{ ucfirst($category) }}</h1>
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
                            <p class="card-text">Цена: {{ number_format($product->price, 0, ',', ' ') }} сум</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
