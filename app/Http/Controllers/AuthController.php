<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('is_login')) {
            return Session::get('role') == 'Pembeli' ? redirect('/') : redirect('/admin/dashboard');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }
    public function showRegisterAdmin()
    {
        return view('auth.register_admin');
    }

    public function login(Request $request)
    {
        $request->validate(['username' => 'required', 'password' => 'required']);

        // 1. Cek Penjual (Admin/Pemilik)
        $user = Penjual::where('username', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Session::put(['is_login' => true, 'id_user' => $user->id_user, 'role' => $user->role, 'nama_user' => $user->nama_user]);
            return redirect('/admin/dashboard');
        }

        // 2. Cek Pelanggan (Pembeli)
        $user = Pelanggan::where('username', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Session::put(['is_login' => true, 'id_pelanggan' => $user->id_pelanggan, 'role' => 'Pembeli', 'nama_user' => $user->nama_pelanggan]);
            return redirect('/');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pelanggans|unique:penjuals',
            'password' => 'required',
            'nama_pelanggan' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        Pelanggan::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect('/login')->with('success', 'Daftar Berhasil, Silahkan Login');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:penjuals|unique:pelanggans',
            'password' => 'required',
            'nama_penjual' => 'required', 
            'role' => 'required'
        ]);

        Penjual::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_user' => $request->nama_penjual, 
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => $request->role
        ]);

        return redirect('/login')->with('success', 'Daftar Admin Berhasil');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
