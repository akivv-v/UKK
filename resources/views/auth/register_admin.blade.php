@extends('layouts.app')

@section('content')
    <div class="row justify-content-center fw-bold">
        <div class="col-md-6">
            <div class="card mt-2 shadow-sm">
                <h3 class="text-center mt-4 fw-bold">Daftar Pengelola</h3>
                <div class="card-body">
                    <form action="{{ url('/register-admin') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama Lengkap :</label>
                            <input type="text" name="nama_penjual" class="form-control" placeholder="Contoh : Ahmad Sanusi"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Username :</label>
                            <input type="text" name="username" class="form-control" placeholder="Contoh : ahmad_admin"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Password :</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>No. HP :</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="Contoh : 081*********"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Alamat :</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap tempat tinggal" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Daftar Sebagai (Role) :</label>
                            <select name="role" class="form-select" required>
                                <option value="" selected disabled>Pilih posisi anda..</option>
                                <option value="Admin">Admin</option>
                                <option value="Pemilik Toko">Pemilik Toko</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">Daftar Pengelola</button>

                        <div class="text-center mt-3">Sudah punya akun?
                            <a href="{{ url('/login') }}">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
