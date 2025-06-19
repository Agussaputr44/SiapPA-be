<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Pengaduans;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PengaduansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pengaduans = Pengaduans::latest()->get();
            return response()->json($pengaduans, 200);
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
        $validated = $request->validate([
            'namaKorban'    => 'required|string|max:255',
            'alamat'        => 'required|string|max:255',
            'aduan'         => 'required|string',
            'harapan'       => 'required|string',
            'status'        => 'nullable|string|max:100',
            'pelapor'       => 'required|string|max:255',
            'evidenceUrls'  => 'nullable|string',  // Jika URL dikirim sebagai string JSON
            'evidencePaths' => 'nullable|string',  // Sama seperti di atas
        ]);

        try {
            $pengaduan = Pengaduans::create($validated);
            return response()->json($pengaduan, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to store data',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pengaduan = Pengaduans::findOrFail($id);
            return response()->json($pengaduan, 200);
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
        $validated = $request->validate([
            'namaKorban'    => 'sometimes|required|string|max:255',
            'alamat'        => 'sometimes|required|string|max:255',
            'aduan'         => 'sometimes|required|string',
            'harapan'       => 'sometimes|required|string',
            'status'        => 'sometimes|nullable|string|max:100',
            'pelapor'       => 'sometimes|required|string|max:255',
            'evidenceUrls'  => 'sometimes|nullable|string',
            'evidencePaths' => 'sometimes|nullable|string',
        ]);

        try {
            $pengaduan = Pengaduans::findOrFail($id);
            $pengaduan->update($validated);
            return response()->json($pengaduan, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pengaduans = Pengaduans::findOrFail($id);
            $pengaduans->delete();
            return response()->json(['message' => 'Jenis Sampah deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete data', 'message' => $e->getMessage()], 500);
        }
    }
}
