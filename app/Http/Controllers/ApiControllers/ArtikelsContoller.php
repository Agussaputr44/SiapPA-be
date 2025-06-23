<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Artikels;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

/**
 * ArtikelsController handles the CRUD operations for Artikels model.
 */
class ArtikelsContoller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/artikels",
     *     operationId="getArtikelsList",
     *     tags={"Artikels"},
     *     security={{"sanctum": {}}},
     *     summary="Get list of artikels",
     *     description="Returns a list of artikels ordered by the latest first",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Artikels")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to fetch data"),
     *             @OA\Property(property="message", type="string", example="Error message details")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/v1/artikels",
     *     operationId="createArtikel",
     *     tags={"Artikels"},
     *    security={{"sanctum": {}}},
     *     summary="Create a new artikel",
     *     description="Creates a new artikel and returns the created artikel data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="judul", type="string", example="Judul Artikel", description="Judul artikel, maksimum 255 karakter"),
     *             @OA\Property(property="isi", type="string", example="Isi artikel...", description="Isi artikel"),
     *             @OA\Property(property="foto", type="string", example="path/to/foto.jpg", description="Path atau URL ke file foto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Artikel created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Artikels")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to create data"),
     *             @OA\Property(property="message", type="string", example="Error message details")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        Log::info('Request data: ', $request->all());

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
     * @OA\Get(
     *     path="/api/v1/artikels/{id}",
     *     operationId="getArtikelById",
     *     tags={"Artikels"},
     *     security={{"sanctum": {}}},
     *     summary="Get artikel by ID",
     *     description="Returns a single artikel based on ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of artikel to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Artikels")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Artikel not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Data not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to fetch data"),
     *             @OA\Property(property="message", type="string", example="Error message details")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/v1/artikels/{id}",
     *     operationId="updateArtikel",
     *     tags={"Artikels"},
     *      security={{"sanctum": {}}},
     *     summary="Update an existing artikel",
     *     description="Updates an existing artikel and returns the updated artikel data",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of artikel to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="judul", type="string", example="Judul Artikel Baru", description="Judul artikel, maksimum 255 karakter"),
     *             @OA\Property(property="isi", type="string", example="Isi artikel yang diperbarui...", description="Isi artikel"),
     *             @OA\Property(property="foto", type="string", example="path/to/foto_baru.jpg", description="Path atau URL ke file foto", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Artikel updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Artikels")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Artikel not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Data not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to update data"),
     *             @OA\Property(property="message", type="string", example="Error message details")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/v1/artikels/{id}",
     *     operationId="deleteArtikel",
     *     tags={"Artikels"},
     *      security={{"sanctum": {}}},
     *     summary="Delete an artikel",
     *     description="Deletes an artikel based on ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of artikel to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Artikel deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Artikel deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Artikel not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Data not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to delete data"),
     *             @OA\Property(property="message", type="string", example="Error message details")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $artikels = Artikels::findOrFail($id);
            $artikels->delete();
            return response()->json(['message' => 'Artikel deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete data', 'message' => $e->getMessage()], 500);
        }
    }
}
