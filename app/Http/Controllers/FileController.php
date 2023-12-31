<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function student() {
        $path = storage_path("app/public/templates/template-student.xlsx");

        abort_if(!File::exists($path), 404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);

        return $response;
    }

    public function teacher() {
        $path = storage_path("app/public/templates/template-teacher.xlsx");

        abort_if(!File::exists($path), 404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);

        return $response;
    }
}
