<?php

namespace App\Http\Controllers;

use App\Models\EstudianteGrupo;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Grupo;

class EstudianteGrupoController extends Controller
{
    public function index(Request $request)
    {
        $query = EstudianteGrupo::query();

        if ($request->has('estudiante_id') && is_numeric($request->estudiante_id)) {
            $query->where('estudiante_id', $request->estudiante_id);
        }

        $estudiantesGrupos = $query->with('estudiante', 'grupo')
            ->orderBy('id', 'desc')
            ->simplePaginate(10);

        $estudiantes = Estudiante::all();

        return view('estudiantes_grupos.index', compact('estudiantesGrupos', 'estudiantes'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();
        return view('estudiantes_grupos.create', compact('estudiantes', 'grupos'));
    }

    public function store(Request $request)
    {
        $estudianteGrupo = EstudianteGrupo::create($request->all());
        return redirect()->route('estudiantes_grupos.index')->with('success', 'GRUPO DE ESTUDIANTES CREADO CORRECTAMENTE.');
    }

    public function show($id)
    {
        $estudianteGrupo = EstudianteGrupo::find($id);

        if (!$estudianteGrupo) {
            return abort(404);
        }

        return view('estudiantes_grupos.show', compact('estudianteGrupo'));
    }

    public function edit($id)
    {
        $estudianteGrupo = EstudianteGrupo::find($id);

        if (!$estudianteGrupo) {
            return abort(404);
        }

        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();

        return view('estudiantes_grupos.edit', compact('estudianteGrupo', 'estudiantes', 'grupos'));
    }

    public function update(Request $request, $id)
    {
        $estudianteGrupo = EstudianteGrupo::find($id); // Corregido el nombre de la variable

        if (!$estudianteGrupo) {
            return abort(404);
        }

        $estudianteGrupo->estudiante_id = $request->estudiante_id;
        $estudianteGrupo->grupo_id = $request->grupo_id;
        $estudianteGrupo->save();

        return redirect()->route('estudiantes_grupos.index')->with('success', 'GRUPO DE ESTUDIANTES ACTUALIZADO CORRECTAMENTE.');
    }

    public function delete($id)
    {
        $estudianteGrupo = EstudianteGrupo::find($id);

        if (!$estudianteGrupo) {
            return abort(404);
        }

        return view('estudiantes_grupos.delete', compact('estudianteGrupo'));
    }

    public function destroy($id)
    {
        $estudianteGrupo = EstudianteGrupo::find($id);

        if (!$estudianteGrupo) {
            return abort(404);
        }

        $estudianteGrupo->delete();

        return redirect()->route('estudiantes_grupos.index')->with('success', 'GRUPO DE ESTUDIANTES ELIMINADO CORRECTAMENTE.');
    }
}
