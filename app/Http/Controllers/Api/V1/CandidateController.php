<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'manager') {
            $candidates = Candidate::latest()->paginate();
        } else {
            $candidates = Candidate::where('owner', $user->id)->latest()->paginate();
        }
        return CandidateResource::collection($candidates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 'manager') {
            return response()->json([
                'status' => false,
                'message' => 'No tienes permiso para crear candidatos',
            ], 401);
        }

        // Validar la solicitud
        $validator = $request->validate([
            'name' => 'required',
            'source' => 'required',
            'owner' => 'required|exists:users,id',
        ], [
            'owner.exists' => 'El owner no existe en la tabla de usuarios',
        ]);

        Candidate::create([
            'name' => $validator['name'],
            'source' => $validator['source'],
            'owner' => $validator['owner'],
            'created_by' => auth()->user()->id, // Guarda el usuario que está creando al candidato
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Candidato Registrado satisfactoriamente',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $candidate = Candidate::findOrFail($id);
        return new CandidateResource($candidate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
