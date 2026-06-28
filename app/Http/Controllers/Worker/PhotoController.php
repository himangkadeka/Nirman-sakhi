<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function savePhoto(Request $request)
    {
        // Process the received image data
        $imageData = $request->input('imageData');
        // Save the image to disk or perform other operations
    }
}
