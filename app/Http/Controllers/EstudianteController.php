<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Estudiante::query();
    
        if($request->has('nombres')){
            $query->where('nombres', 'like', '%' . $request->nombres . '%');
        }
    
        if($request->has('apellidos')){
            $query->where('apellidos', 'like', '%' . $request->apellidos . '%');
        }
    
        $estudiantes = $query->orderBy('id', 'desc')->simplePaginate(10);
    
        return view('estudiantes.index', compact('estudiantes'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estudiantes.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        'email' => 'required|email|unique:estudiante,email',
        'pin' => 'required',
    ]);

    $request->merge(['pin' => Hash::make($request->pin)]);

    $estudiante = Estudiante::create($request->all());

    return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente.');
}

    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        return view('estudiantes.show', compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }
        return view('estudiantes.edit', compact('estudiante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:estudiante,email,' . $id,
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    /**
     * Show the form for confirming the deletion.
     */
    public function delete($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        return view('estudiantes.delete', compact('estudiante'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return abort(404);
        }

        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', "Estudiante eliminado correctamente.");
    }

    public function showLoginForm()
    {
        return view('estudiantes.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'pin');

        if (Auth::guard('estudiante')->attempt($credentials)){
            return redirect()->intended();       
         }
        return  redirect()->back()->withErrors([
            'InvalidCredentials' => 'Las credenciales proporcionadas no coinciden con nuestros registros',
        ]);
    }

    public function logout()
    {
        Auth::guard('estudiante')->logout();
        return redirect()->route('estudiantes.showLoginForm');
    }
}
