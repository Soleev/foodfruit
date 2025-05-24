@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Управление пользователями</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                           name="email" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                           name="password" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Добавить пользователя</button>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Оборот</th>
                <th>Долг</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ number_format($user->orders->sum('total_price'), 0, ',', ' ') }} сум</td>
                    <td>{{ number_format($user->debt, 0, ',', ' ') }} сум</td>

                    <td>
                        <a href="{{ route('admin.users.buy', $user) }}" class="btn btn-sm btn-primary">Купить товар</a>
                        <a href="{{ route('admin.users.orders', $user) }}" class="btn btn-sm btn-info">История
                            покупок</a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">Пользователей пока нет.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
