<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|numeric|digits:10|unique:usuarios,cedula',
            'correo' => 'required|string|email|unique:usuarios,correo',
            'telefono' => 'required|numeric|digits_between:7,10',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $usuario = new Usuario;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->cedula = $request->cedula;
        $usuario->correo = $request->correo;
        $usuario->telefono = $request->telefono;
        $usuario->save();
    
        return response()->json(['message' => 'Usuario creado correctamente'], 201);
    }
    
    public function show(Usuario $usuario)
    {
        return $usuario;
    }

    public function update(Request $request, Usuario $usuario)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|numeric|digits:10|unique:usuarios,cedula,' . $usuario->id,
            'correo' => 'required|string|email|unique:usuarios,correo,' . $usuario->id,
            'telefono' => 'required|numeric|digits_between:7,10',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->cedula = $request->cedula;
        $usuario->correo = $request->correo;
        $usuario->telefono = $request->telefono;
        $usuario->update();
    
        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}
