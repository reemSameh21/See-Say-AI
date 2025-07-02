import sys
from youtube_transcript_api import YouTubeTranscriptApi
from urllib.parse import urlparse, parse_qs
import requests
import os
from dotenv import load_dotenv

load_dotenv()

def get_video_id(url):
    query = urlparse(url)
    if query.hostname == 'youtu.be':
        return query.path[1:]
    elif query.hostname in ['www.youtube.com', 'youtube.com']:
        return parse_qs(query.query).get('v', [None])[0]
    return None

# تحميل الترانسكريبشن
def get_transcript(video_id):
    try:
        transcript = YouTubeTranscriptApi.get_transcript(video_id)
        return " ".join([entry['text'] for entry in transcript])
    except Exception as e:
        return None

# تلخيص النص باستخدام Hugging Face
def summarize_text(text, token):
    headers = {
        "Authorization": f"Bearer {token}",
        "Content-Type": "application/json"
    }

    payload = {
        "inputs": text
    }

    response = requests.post(
        "https://api-inference.huggingface.co/models/facebook/bart-large-cnn",
        headers=headers,
        json=payload
    )

    if response.status_code == 200:
        return response.json()[0]['summary_text']
    else:
        return f"Error: {response.status_code} - {response.text}"

# نقطة التشغيل
if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Error: Please provide a YouTube URL.")
        sys.exit(1)

    youtube_url = sys.argv[1]
    hf_token = os.getenv("HF_TOKEN")  # تأكدي إنه متسجل في البيئة

    if not hf_token:
        print("Error: Hugging Face token not set in environment variable HF_TOKEN.")
        sys.exit(1)

    video_id = get_video_id(youtube_url)
    if not video_id:
        print("Error: Invalid YouTube URL.")
        sys.exit(1)

    transcript = get_transcript(video_id)
    if not transcript:
        print("Error: Could not fetch transcript. Maybe the video has no subtitles.")
        sys.exit(1)

    summary = summarize_text(transcript, hf_token)
    print(summary)
