<?php

// Получаем данные из тела POST-запроса
$jsonPayload = file_get_contents('php://input');
$data = json_decode($jsonPayload, true);

// Проверка наличия секретного токена (замените YOUR_SECRET_TOKEN)
$secret = '123';
if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    die('Invalid signature');
}

$hubSignature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
list($algo, $hash) = explode('=', $hubSignature, 2);

$payloadHash = hash_hmac($algo, $jsonPayload, $secret);

if ($hash !== $payloadHash) {
    die('Invalid signature');
}

// Выполняем git pull (замените на свою команду)
$output = shell_exec('git pull origin main 2>&1');

// Логируем результат
file_put_contents('/var/www/html/webhook.log', $output . PHP_EOL, FILE_APPEND);

echo 'Webhook received successfully';
