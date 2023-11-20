<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function __invoke(?string $filename) 
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
}
