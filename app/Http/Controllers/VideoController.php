<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function summarize(Request $request)
    {
        $url = $request->input('youtube_url');

        $scriptPath = '/home/rora/ml-project/summarize_video.py';
        $pythonPath = '/home/rora/ml-project/imagegen-env/bin/python3';

        $command = escapeshellcmd("{$pythonPath} {$scriptPath} {$url}");
        $output = shell_exec("{$command} 2>&1");

        return view('app', [
            'summary' => $output,
            'active_tab' => 'video',
        ]);
    }

    public function translate(Request $request)
    {
        $text = $request->input('summary');
        $direction = $request->input('direction'); // "ar-en" or "en-ar"

        $model = $direction === 'ar-en' 
            ? 'Helsinki-NLP/opus-mt-ar-en' 
            : 'Helsinki-NLP/opus-mt-en-ar';

        $scriptPath = '/home/rora/ml-project/translate_summary.py';
        $pythonPath = '/home/rora/ml-project/imagegen-env/bin/python3';

        $escapedText = escapeshellarg($text);
        $command = "{$pythonPath} {$scriptPath} {$escapedText} {$model}";
        $translated = shell_exec("{$command} 2>&1");

        return view('app', [
            'summary' => $text,
            'translated' => $translated,
            'direction' => $direction,
            'active_tab' => 'video',
        ]);
    }
}
