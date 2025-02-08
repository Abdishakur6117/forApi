<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}

$name = $_POST['name'] ?? '';
$number = $_POST['tell'] ?? '';

if (!$name || !$number) {
    echo json_encode(["status" => "error", "message" => "Both name and WhatsApp number are required."]);
    exit;
}

$params = [
    'token' => 'mofcgbsdo4ve3bwh', // Replace with your UltraMsg token
    'to' => $number,
    'body' => "Hello $name, congratulations! You've successfully used WhatsApp API via UltraMsg.",
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.ultramsg.com/instance106531/messages/chat",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => http_build_query($params),
    CURLOPT_HTTPHEADER => [
        "content-type: application/x-www-form-urlencoded",
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

if ($err) {
    error_log("cURL Error: $err"); // Log the error
    echo json_encode(["status" => "error", "message" => "cURL Error: $err"]);
} else {
    error_log("Response: $response"); // Log the response
    $result = json_decode($response, true);
    if ($result['sent'] ?? false) {
        echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => $result['message'] ?? 'Failed to send message.']);
    }
}


