<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Pengaduans;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Schema(
 *     schema="PengaduanRequest",
 *     required={"namaKorban", "alamat", "aduan", "kategoriKekerasan", "harapan"},
 *     @OA\Property(property="namaKorban", type="string", example="Siti Nurhaliza"),
 *     @OA\Property(property="alamat", type="string", example="Jl. Merdeka No. 123"),
 *     @OA\Property(property="aduan", type="string", example="Saya mengalami kekerasan."),
 *     @OA\Property(property="kategoriKekerasan", type="string", enum={"kekerasan_fisik", "kekerasan_seksual", "kekerasan_lainnya"}, example="kekerasan_fisik"),
 *     @OA\Property(property="harapan", type="string", example="Saya berharap pelaku dihukum."),
 *     @OA\Property(property="status", type="string", nullable=true, example="terkirim"),
 *     @OA\Property(property="evidenceUrls", type="string", nullable=true, example="https://example.com/evidence.jpg"),
 *     @OA\Property(property="evidencePaths", type="string", nullable=true, example="evidence/image.jpg")
 * )
 */
class PengaduansController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/pengaduans",
     *     summary="Get list of pengaduans",
     *     tags={"Pengaduans"},
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index()
    {
        try {
            $pengaduans = Pengaduans::latest()->get();
            return response()->json($pengaduans, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/pengaduans",
     *     summary="Create a new pengaduan",
     *     tags={"Pengaduans"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PengaduanRequest")
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(Request $request)
    {
        Log::info('Request data: ', $request->all());

        $validated = $request->validate([
            'namaKorban' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'aduan' => 'required|string',
            'kategoriKekerasan' => 'required|in:kekerasan_fisik,kekerasan_seksual,kekerasan_lainnya',
            'harapan' => 'required|string',
            'status' => 'nullable|in:terkirim,diproses,selesai',
            'evidenceUrls' => 'nullable|string',
            'evidencePaths' => 'nullable|string',
        ]);

        try {
            $pelapor_id = $request->user()->id;
            $validated['pelapor'] = $pelapor_id;
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
     * @OA\Get(
     *     path="/api/v1/pengaduans/{id}",
     *     summary="Get a specific pengaduan",
     *     tags={"Pengaduans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Data not found")
     * )
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
     * @OA\Put(
     *     path="/api/v1/pengaduans/{id}",
     *     summary="Update a specific pengaduan",
     *     tags={"Pengaduans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PengaduanRequest")
     *     ),
     *     @OA\Response(response=200, description="Updated"),
     *     @OA\Response(response=404, description="Data not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'namaKorban' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string|max:255',
            'aduan' => 'sometimes|required|string',
            'harapan' => 'sometimes|required|string',
            'kategoriKekerasan' => 'sometimes|required|in:kekerasan_fisik,kekerasan_seksual,kekerasan_lainnya',
            'status' => 'sometimes|nullable|string|max:100',
            'pelapor' => 'sometimes|required|string|max:255',
            'evidenceUrls' => 'sometimes|nullable|string',
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
     * @OA\Delete(
     *     path="/api/v1/pengaduans/{id}",
     *     summary="Delete a pengaduan",
     *     tags={"Pengaduans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Deleted"),
     *     @OA\Response(response=404, description="Data not found")
     * )
     */
    public function destroy($id)
    {
        try {
            $pengaduans = Pengaduans::findOrFail($id);
            $pengaduans->delete();
            return response()->json(['message' => 'Pengaduan deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete data', 'message' => $e->getMessage()], 500);
        }
    }
}
