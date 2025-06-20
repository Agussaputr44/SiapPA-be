<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
 * UploadsFilesController handles file uploads for various media types.
 * It validates the files and stores them in the 'uploads' directory.
 */

class UploadsFilesController extends Controller
{


    /**
     * Handle the file upload request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function uploadFiles(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,jpg,png,gif,svg,mp4,mov,avi|max:20480',
        ]);

        $paths = [];

        foreach ($request->file('files') as $file) {
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');
            $paths[] = Storage::url($path);
        }

        return response()->json([
            'files' => $paths
        ], 200);
    }
}
