import sys
import os
import requests
from dotenv import load_dotenv

load_dotenv()

HF_TOKEN = os.getenv("HF_TOKEN")

def translate(text, model):
    headers = {
        "Authorization": f"Bearer {HF_TOKEN}",
        "Content-Type": "application/json"
    }

    payload = {
        "inputs": text
    }

    response = requests.post(
        f"https://api-inference.huggingface.co/models/{model}",
        headers=headers,
        json=payload
    )

    if response.status_code == 200:
        return response.json()[0]['translation_text']
    else:
        return f"Error: {response.status_code} - {response.text}"

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Usage: python translate_summary.py \"Text to translate\" model_name")
        sys.exit(1)

    text = sys.argv[1]
    model_name = sys.argv[2]

    result = translate(text, model_name)
    print(result)
