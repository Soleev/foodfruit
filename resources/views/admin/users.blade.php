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
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="store_name" class="form-label">Наименование магазина</label>
                    <input type="text" class="form-control @error('store_name') is-invalid @enderror" id="store_name" name="store_name">
                    @error('store_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="address" class="form-label">Адрес</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address">
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Добавить пользователя</button>
        </form>

        <table class="table table-hover table-sm">
            <caption>List of users</caption>
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Имя</th>
                <th scope="col">Email</th>
                <th scope="col">Наименование магазина</th>
                <th scope="col">Телефон</th>
                <th scope="col">Адрес</th>
                <th scope="col">Оборот</th>
                <th scope="col">Долг</th>
                <th scope="col">Оплата</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            @forelse ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->store_name ?? '-' }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->address ?? '-' }}</td>
                    <td>{{ number_format($user->orders->sum('total_price'), 0, ',', ' ') }} сум</td>

                    @if($user->debt > 0)
                        <td class="table-danger">{{ number_format($user->debt, 0, ',', ' ') }} сум</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>
                        @if($user->debt > 0)
                            <form action="{{ route('admin.users.payDebt', $user) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="number" name="amount" class="form-control form-control-sm d-inline-block w-auto" min="0" max="{{ $user->debt }}" placeholder="Сумма" required>
                                <button type="submit" class="btn btn-sm btn-success">Оплатить</button>
                            </form>
                        @else
                            <span class="text-success">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.buy', $user) }}" class="btn btn-sm btn-primary">Купить товар</a>
                        <a href="{{ route('admin.users.orders', $user) }}" class="btn btn-sm btn-info">История покупок</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Пользователей пока нет.</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot class="table-dark">
            <th scope="row">{{$totalUsers}}</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="table-danger">{{ number_format($totalDebt, 0, ',', ' ') }} сум</td>
            <td></td>
            <td></td>
            </tfoot>
        </table>
    </div>
@endsection
