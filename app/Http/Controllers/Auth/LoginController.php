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
    }

    protected function authenticated(Request $request, $user)
    {
        // Siapkan pesan notifikasi
        $message = 'Login berhasil! Selamat datang, ' . $user->name;

        // Periksa apakah pengguna adalah admin
        if ($user->is_admin) {
            // Jika admin, arahkan ke dashboard admin dengan pesan notifikasi
            return redirect()->route('admin.dashboard.index')->with('success', $message);
        }

        // Jika bukan admin, arahkan ke halaman utama dengan pesan notifikasi
        return redirect()->route('home')->with('success', $message);
    }
}
