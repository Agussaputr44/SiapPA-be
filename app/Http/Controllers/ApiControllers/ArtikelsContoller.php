<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Artikels;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArtikelsContoller extends Controller


{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $artikels = Artikels::latest()->get();
            return response()->json($artikels, 200);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'Failed to fetch data',
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'required|string|max:255',
        ]);

        try {
            $artikels = Artikels::create($request->all());
            return response()->json($artikels, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create data', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $artikels = Artikels::findOrFail($id);
            return response()->json($artikels, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch data', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|string|max:255', 
        ]);

        try {
            $artikels = Artikels::findOrFail($id);
            $artikels->update($request->only(['judul', 'isi', 'foto']));
            return response()->json($artikels, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update data', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $artikels = Artikels::findOrFail($id);
            $artikels->delete();
            return response()->json(['message' => 'Jenis Sampah deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete data', 'message' => $e->getMessage()], 500);
        }
    }
}
