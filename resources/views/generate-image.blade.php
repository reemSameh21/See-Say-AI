<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>AI Image Generation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 30px;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #007acc;
        }
        img {
            margin-top: 20px;
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .prompt-text {
            margin-top: 10px;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>AI Image Generation 🎨</h1>

    <form method="POST" action="{{ route('generate-image') }}">
        @csrf
        <input type="text" name="prompt" placeholder="Example: A cat riding a bike" required>
        <button type="submit">Generate Image</button>
    </form>

    @if(isset($prompt))
        <div class="prompt-text">Prompt: "{{ $prompt }}"</div>
    @endif

    @if(isset($image_url))
        <img src="{{ $image_url }}" alt="Generated Image">
    @endif
</body>
</html>
