<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CkeditorUploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('upload')) {
            return response()->json(['error' => ['No file uploaded.']], 400);
        }
        $file = $request->file('upload');
        // Store to storage/app/public/ckeditor/ (accessible via /storage/ symlink)
        $path = $file->store('ckeditor', 'public');
        $url = '/storage/' . $path;
        return response()->json(['url' => $url]);
    }
}
