<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['message']) || empty($input['message'])) {
    echo json_encode(['reply' => 'Invalid input.']);
    exit;
}

$message = $input['message'];

// OpenAI API details
$apiKey = 'your_openai_api_key';
$apiUrl = 'https://api.openai.com/v1/engines/davinci-codex/completions';

$data = [
    'prompt' => $message,
    'max_tokens' => 50,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['reply' => 'Request Error:' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$result = json_decode($response, true);
$reply = $result['choices'][0]['text'];

echo json_encode(['reply' => $reply]);
?>
