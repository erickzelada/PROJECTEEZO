<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Grupo;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asistencia::query();

        if ($request->filled('grupo_id') && is_numeric($request->grupo_id)) {
            $query->where('grupo_id', '=', $request->grupo_id);
        }

        $asistencias = $query->with('estudiante', 'grupo')
            ->orderBy('fecha', 'desc')
            ->simplePaginate(10);

        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();

        return view('asistencias.index', compact('asistencias', 'estudiantes', 'grupos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();
        return view('asistencias.create', compact('estudiantes', 'grupos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Asistencia::create($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }
        
        return view('asistencias.show', compact('asistencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }

        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();

        return view('asistencias.edit', compact('asistencia', 'estudiantes', 'grupos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([]);

        $asistencia = Asistencia::find($id);
        
        if (!$asistencia) {
            return abort(404);
        }

        $asistencia->update($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    public function delete($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia){
            return abort(404);
        }

        return view('asistencias.delete', compact('asistencia'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return abort(404);
        }

        $asistencia->delete();

        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }

    public function showLoginForm()
    {
        return view('asistencias.marcar');
    }

    public function marcarAsistencias(Request $request)
{
    
    $request->validate([
        'pin' => 'required',
    ]);

    
    $estudiante = Estudiante::where('pin', $request->pin)->first();

    
    if (!$estudiante || !Hash::check($request->pin, $estudiante->pin)) {
        return back()->withErrors(['InvalidCredentials' => 'PIN incorrecto.'])->withInput();
    }

   
    Asistencia::create([
        'estudiante_id' => $estudiante->id,
        'grupo_id' => $estudiante->grupo_id, 
        'fecha' => now()->toDateString(),
        'hora_entrada' => now()->toTimeString(),
    ]);

    return redirect()->route('asistencias.index')->with('success', 'Asistencia marcada correctamente.');
}

}
