<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Arahkan ke halaman home setelah login
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Middleware pengaman
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Tambahan notifikasi setelah login sukses
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect('/home')->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
    }
}
