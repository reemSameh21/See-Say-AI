<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ML Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 40px;
            text-align: center;
        }
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            background: #e0e0e0;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 8px 8px 0 0;
        }
        .tab.active {
            background: #ffffff;
            font-weight: bold;
            border-bottom: 2px solid #ffffff;
        }
        .tab-content {
            background: #ffffff;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], textarea, select {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background: #007acc;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #005f99;
        }
        img {
            margin-top: 20px;
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <h1>ML Project 🧠</h1>

    <div class="tabs">
        <div class="tab {{ (isset($active_tab) && $active_tab === 'image') || !isset($active_tab) ? 'active' : '' }}" onclick="showTab('image')">Generate Image</div>
        <div class="tab {{ (isset($active_tab) && $active_tab === 'video') ? 'active' : '' }}" onclick="showTab('video')">Summarize YouTube</div>
    </div>

    <!-- Image Generation Tab -->
    <div id="image" class="tab-content">
        <form method="POST" action="{{ route('generate-image') }}">
            @csrf
            <input type="text" name="prompt" placeholder="Describe the image..." required>
            <br>
            <button type="submit">Generate Image</button>
        </form>

        @if(isset($prompt))
            <p><strong>Prompt:</strong> "{{ $prompt }}"</p>
        @endif

        @if(isset($image_url))
            <img src="{{ $image_url }}" alt="Generated Image">
        @endif
    </div>

    <!-- Video Summarization Tab -->
    <div id="video" class="tab-content" style="display: none;">
        <form method="POST" action="{{ route('summarize-video') }}">
            @csrf
            <input type="text" name="youtube_url" placeholder="Paste YouTube video link..." required>
            <br>
            <button type="submit">Summarize Video</button>
        </form>

        @if(isset($summary))
            <h3>Summary:</h3>
            <textarea rows="6" readonly>{{ $summary }}</textarea>

            <!-- Translation Form -->
            <form method="POST" action="{{ route('translate-summary') }}">
                @csrf
                <input type="hidden" name="summary" value="{{ $summary }}">
                <select name="direction">
                    <option value="en-ar" {{ (isset($direction) && $direction == 'en-ar') ? 'selected' : '' }}>English to Arabic</option>
                    <option value="ar-en" {{ (isset($direction) && $direction == 'ar-en') ? 'selected' : '' }}>Arabic to English</option>
                </select>
                <br>
                <button type="submit">Translate</button>
            </form>
        @endif

        @if(isset($translated))
            <h3>Translation:</h3>
            <textarea rows="6" readonly>{{ $translated }}</textarea>
        @endif
    </div>

    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
            document.querySelector('.tab[onclick="showTab(\'' + tab + '\')"]').classList.add('active');
            document.getElementById(tab).style.display = 'block';
        }

        window.onload = function () {
            let active = '{{ $active_tab ?? 'image' }}';
            showTab(active);
        };
    </script>

</body>
</html>
