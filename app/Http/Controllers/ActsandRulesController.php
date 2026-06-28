<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActsandRulesController extends Controller
{
    public function downloadFile($fileName)
    {
        $filePath = public_path('pdf/Acts_and_Rules/' . $fileName);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return abort(404, 'File not found');
        }

    }
}
