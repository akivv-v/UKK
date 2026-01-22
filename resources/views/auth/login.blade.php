@extends('layouts.app')

@section('content')
<div class="row justify-content-center fw-bold">
    <div class="col-md-6">
        <div class="card mt-5">
            <h3 class="text-center mt-4 fw-bold">Masuk</h3>
            <div class="card-body">
                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Username :</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username yang sudah dibuat" required>
                    </div>
                    <div class="mb-3">
                        <label>Password :</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password yang sudah dibuat" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Masuk</button>
                    <div class="text-center mt-3">Belum punya akun? 
                        <a href="{{ url('/register') }}">Daftar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
