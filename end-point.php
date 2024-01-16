<?php

// Открываем файл для записи логов
$logFile = '/var/www/html/webhook.log';
$log = fopen($logFile, 'a');

// Получаем данные из параметра data в GET запросе
$jsonPayload = isset($_GET['data']) ? urldecode($_GET['data']) : '';
// Логируем данные (временно, для отладки)
fwrite($log, "Received payload:\n$jsonPayload\n\n");

// Проверяем, если данные приходят в JSON, логируем их разбор
$data = json_decode($jsonPayload, true);
if ($data !== null) {
    fwrite($log, "Decoded JSON data:\n" . print_r($data, true) . "\n\n");
} else {
    fwrite($log, "Failed to decode JSON data.\n\n");
}

// Выполняем git pull (замените на свою команду)
$output = shell_exec('git pull origin main 2>&1');

// Логируем результат
fwrite($log, "Git pull output:\n$output\n\n");

// Закрываем файл лога
fclose($log);

echo 'Webhook received successfully';
