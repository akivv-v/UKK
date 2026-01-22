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
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cek Penjual
        $penjual = Penjual::where('username', $request->username)->first();
        if ($penjual) {
            // Check Hash first (Secure)
            if (Hash::check($request->password, $penjual->password)) {
                 Session::put('id_user', $penjual->id_user);
                 Session::put('role', $penjual->role);
                 Session::put('is_login', true);
                 return redirect('/admin/dashboard');
            }
            // Fallback: Check Plain Text (Simple)
            elseif ($penjual->password == $request->password) {
                 Session::put('id_user', $penjual->id_user);
                 Session::put('role', $penjual->role);
                 Session::put('is_login', true);
                 return redirect('/admin/dashboard');
            }
        }

        // Cek Pelanggan
        $pelanggan = Pelanggan::where('username', $request->username)->first();
        if ($pelanggan) {
            if (Hash::check($request->password, $pelanggan->password)) {
                Session::put('id_pelanggan', $pelanggan->id_pelanggan);
                Session::put('role', 'Pembeli');
                Session::put('is_login', true);
                return redirect('/');
            }
        }

        return back()->with('error', 'Username atau Password salah');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pelanggans',
            'password' => 'required',
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ]);

        Pelanggan::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
