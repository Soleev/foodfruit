@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Каталог</h1>
        <div class="row">
            @foreach ($categories as $key => $category)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category }}</h5>
                            <a href="{{ route('catalog', $key) }}" class="btn btn-primary">Перейти</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
