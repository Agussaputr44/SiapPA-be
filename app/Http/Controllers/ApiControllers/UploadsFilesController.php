<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UploadsFilesController extends Controller
{


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
