@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Marcar Asistencia</h1>
        <div class="d-flex justify-content-center">
            <form action="{{ route('asistencias.marcar') }}" method="POST" class="w-50">
                @csrf
                <div class="mb-3">
                    <label for="pin" class="form-label text-center d-block">Pin</label>
                    <input type="password" class="form-control" id="pin" name="pin" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Marcar</button>
                </div>
                <div class="mt-3">
                    @error('InvalidCredentials')
                        <div class="alert alert-danger fade show text-center" id="error-message" data-bs-dismiss="alert" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </form>
        </div>
    </div>
@endsection
