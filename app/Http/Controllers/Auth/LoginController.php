<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        if (auth()->user()->isAdmin()) {
            return '/admin/users'; // Админ идёт в админ-панель
        }
        return '/cabinet'; // Обычный пользователь идёт в личный кабинет
    }
}
