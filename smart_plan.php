<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

$origin = $_GET['origin'] ?? '';
$destination = $_GET['destination'] ?? '';

if (!$origin || !$destination) {
    echo "Please provide both origin and destination.";
    exit;
}
$retry = false;
do_again:
$apiKey = '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'; // Replace with your actual key
$endpoint = 'https://openrouter.ai/api/v1/chat/completions';

$data = [
    "model" => "openai/gpt-3.5-turbo",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are a Nepali trekking assistant. When a user provides origin and destination, return the following fields exactly and in this order:

Permit Requirements:
Guide Requirement:
Best Season:
Difficulty Level:
Estimated Cost $:
Estimated Cost NPR:
Trek Time:
Waypoints:

Use the Origin exactly as provided by the user as the first waypoint. Do not replace or omit it.

If the origin is outside the trekking region (like Tokyo), treat it as the starting point and then add the usual trekking waypoints up to the destination.

Do not add extra explanation or greetings. Be concise and direct."
        ],
        [
            "role" => "user",
            "content" => "Plan a trekking trip starting at $origin and ending at $destination. Use $origin exactly as the first waypoint."
        ]
    ],
    "temperature" => 0,
    "max_tokens" => 1000
];

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
];

$options = [
    "http" => [
        "method" => "POST",
        "header" => implode("\r\n", $headers),
        "content" => json_encode($data)
    ]
];

$context = stream_context_create($options);
$response = @file_get_contents($endpoint, false, $context);

if ($response === false) {
    if(!$retry)
    {
        $retry = true;
        goto do_again;
    }else{
        echo "Error connecting to AI.";
        exit;
    }
}

$json = json_decode($response, true);
$content = $json['choices'][0]['message']['content'] ?? '';

$content = preg_replace('/Here[^:\n]*:\s*/i', '', $content); // remove unwanted "Here’s..." text if any
$content = preg_replace('/\n\s*\n/', "\n", $content); // remove excessive newlines

echo nl2br(htmlspecialchars(trim($content)));