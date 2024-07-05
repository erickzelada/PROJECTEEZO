<!-- resources/views/asistencia/reporte.blade.php -->

@extends('layouts.app') <!-- Ajusta según tu estructura de layouts -->

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Reporte de Asistencia</div>

                    <div class="card-body">
                        @if ($asistencias->isEmpty())
                            <p>No hay registros de asistencia para mostrar.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Grupo</th>
                                        <th>Fecha</th>
                                        <th>Hora de Entrada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asistencias as $asistencia)
                                        <tr>
                                            <td>{{ $asistencia->estudiante->nombreCompleto }}</td>
                                            <td>{{ $asistencia->grupo->nombre }}</td>
                                            <td>{{ $asistencia->fecha }}</td>
                                            <td>{{ $asistencia->hora_entrada }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
