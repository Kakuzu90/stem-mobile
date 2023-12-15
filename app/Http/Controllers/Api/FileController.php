<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function index(?string $filename) 
    {
        if ($filename) {
            $path = storage_path("app/public/questions/" . $filename);

            abort_if(!File::exists($path), 404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);

            return $response;
        }
    }

    public function module(string $path) 
    {
        $path = storage_path("app/public/modules/" . $path);

        abort_if(!File::exists($path), 404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);

        return $response;
    }

    public function answer(?string $filename) 
    {
        if ($filename) {
            $path = storage_path("app/public/questions/answer/" . $filename);

            abort_if(!File::exists($path), 404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);

            return $response;
        }
    }
}
