@extends('layouts.app')

@section('content')
<div class="row justify-content-center fw-bold">
    <div class="col-md-6">
        <div class="card mt-4">
            <h3 class="text-center mt-4 fw-bold">Daftar</h3>
            <div class="card-body">
                <form action="{{ url('/register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Lengkap :</label>
                        <input type="text" name="nama_pelanggan" class="form-control" placeholder="Contoh : Vika anjani" required>
                    </div>
                    <div class="mb-3">
                        <label>Username :</label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh : Vika" required>
                    </div>
                    <div class="mb-3">
                        <label>Password :</label>
                        <input type="password" name="password" class="form-control" placeholder="Contoh : vika123" required>
                    </div>
                    <div class="mb-3">
                        <label>No. HP :</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Contoh : 089*********" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat :</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh : jl. raya no.2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Daftar</button>
                    <div class="text-center mt-3">Sudah punya akun?
                        <a href="{{ url('/login') }}">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
