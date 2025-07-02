<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function showHome()
    {
        return view('app');
    }

    public function generateImage(Request $request)
    {
        $prompt = $request->input('prompt');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HF_TOKEN'),
            'Content-Type' => 'application/json',
        ])->timeout(60)->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-xl-base-1.0', [
            'inputs' => $prompt,
        ]);

        if ($response->successful()) {
            $imageData = base64_encode($response->body());
            $imageUrl = 'data:image/png;base64,' . $imageData;
        } else {
            $imageUrl = null;
            dd($response->status(), $response->body());
        }

        return view('app', [
            'prompt' => $prompt,
            'image_url' => $imageUrl,
            'active_tab' => 'image',
        ]);
    }
}
