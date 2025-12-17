<?php
// trek_chatbot.php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Function to clean AI response text
function cleanAIResponse(string $text): string {
    // Remove leading bullets and replace with en dash
    $text = preg_replace('/^\s*[\*\-]\s+/m', '– ', $text);
    // Remove bold/italic markdown syntax
    $text = preg_replace('/\*{1,2}(.+?)\*{1,2}/', '$1', $text);
    // Remove multiple blank lines
    $text = preg_replace("/\n\s*\n+/", "\n\n", $text);
    // Decode HTML entities
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5);
    // Remove stray brackets [] anywhere
    $text = str_replace(['[', ']'], '', $text);
    // Trim whitespace/newlines
    return trim($text);
}

// Handle reset chat request
if (isset($_GET['reset']) && $_GET['reset'] == '1') {
    unset($_SESSION['chat_history']);
    echo json_encode(["answer" => "Chat history cleared. Ask me anything!"]);
    exit;
}

// Initialize chat history with system prompt if not set
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [
        [
            "role" => "system",
            "content" => "You are Lakpa, a highly experienced trekking guide from the Himalayas, working with EcoTrail+. Speak like a real human, not an AI. You are born and raised in Nepal, and have years of experience helping trekkers navigate routes, gear, weather, and altitude sickness. Never say you're an AI, chatbot, assistant, or tool. Give clear, confident, and real-sounding advice including altitude sickness treatment, safety protocol, hydration, gear, trail suggestions, and route planning. Be warm, respectful, and always helpful like a trusted mountain guide. Refer to yourself as 'Lakpa from EcoTrail+'."
        ]
    ];
}


// Read the user question from JSON POST body
$input = file_get_contents("php://input");
$data = json_decode($input, true);
$question = trim($data['question'] ?? '');

if (!$question) {
    echo json_encode(["error" => "Please provide a question."]);
    exit;
}

// Append user question to chat history
$_SESSION['chat_history'][] = [
    "role" => "user",
    "content" => $question
];

// Prepare API request data with full chat history
$apiKey = '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'; // Your OpenRouter/OpenAI API key
$endpoint = 'https://openrouter.ai/api/v1/chat/completions';

$requestData = [
    "model" => "google/gemma-3-12b-it:free",
    "messages" => $_SESSION['chat_history'],
    "temperature" => 0.7,
    "max_tokens" => 1500
];

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
];

$options = [
    "http" => [
        "method" => "POST",
        "header" => implode("\r\n", $headers),
        "content" => json_encode($requestData),
        "timeout" => 30
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($endpoint, false, $context);

if ($response === false) {
    echo json_encode(["error" => "Error connecting to AI."]);
    exit;
}

$json = json_decode($response, true);
$aiReply = $json['choices'][0]['message']['content'] ?? '';

if (!$aiReply) {
    echo json_encode(["error" => "AI did not return a response."]);
    exit;
}

// Clean the AI response
$cleanedContent = cleanAIResponse($aiReply);

// Append AI response to chat history
$_SESSION['chat_history'][] = [
    "role" => "assistant",
    "content" => $aiReply
];

// Return the cleaned AI response as JSON
echo json_encode(["answer" => $cleanedContent]);
