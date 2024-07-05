@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Login Docente</h1>
        <form action="{{ route('docentes.login') }}" method="POST">
            @csrf
            <div class="row justify-content-center mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label text-center d-block">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-4">
                    <label for="password" class="form-label text-center d-block">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-8">
                    @error('InvalidCredentials')
                        <div class="alert alert-danger fade show text-center" id="error-message" data-bs-dismiss="alert" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </form>
    </div>
@endsection
