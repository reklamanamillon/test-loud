<?php

// Получаем данные из тела POST-запроса
$jsonPayload = file_get_contents('php://input');
$data = json_decode($jsonPayload, true);

// Проверка наличия секретного токена (замените YOUR_SECRET_TOKEN)
$secret = 'YOUR_SECRET_TOKEN';
if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    die('Invalid signature - No X-Hub-Signature header present');
}

$hubSignature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
list($algo, $hash) = explode('=', $hubSignature, 2);

$payloadHash = hash_hmac($algo, $jsonPayload, $secret);

if ($hash !== $payloadHash) {
    die('Invalid signature - Hash mismatch');
}

// Выполняем git pull (замените на свою команду)
$output = shell_exec('git pull origin main 2>&1');

// Логируем результат
$logMessage = 'Webhook received successfully. Git pull output: ' . PHP_EOL . $output . PHP_EOL;
file_put_contents('/var/www/html/webhook.log', $logMessage, FILE_APPEND);

echo 'Webhook received successfully';
