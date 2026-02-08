<?php

namespace App\Http\Controllers;

use App\Services\PhotoService;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    protected $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        
        $perPage = (int) $perPage;
        if ($perPage < 1 || $perPage > 100) {
            $perPage = 20;
        }

        $photos = $this->photoService->getAllPhotos($perPage);

        return view('photos.index', compact('photos'));
    }
}
