<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Laboratorio::all();
        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $projects = Laboratorio::create($request->all());

        return response()->json($projects, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $projects = Laboratorio::find($id);
        if(!$projects){
            return response()->json(['mensaje'=>'Laboratorio NO encontrado.'], 401);
        }
        return response()->json($projects);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projects = Laboratorio::find($id);

        /*if(!$projects){
            return response()->json(['message'=>'Proyecto no encontrado.'], 404);
        }*/

        $request->validate([
            'NombreLaboratorio ' => 'sometimes|string',
            'codigo' => 'sometimes|numeric',
        ]);

        $projects->update($request->all());
        return response()->json($projects);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projects = Laboratorio::find($id);

        if(!$projects){
            return response()->json(['message'=>'Proyecto no encontrado'], 404);
        }

        $projects->delete();
        return response()->json(['message'=>'Proyecto Eliminado. ']);
    }
}
