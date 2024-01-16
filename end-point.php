<?php

// Открываем файл для записи логов
$logFile = '/var/www/html/webhook.log';
$log = fopen($logFile, 'a');

// Получаем данные из тела POST-запроса
$jsonPayload = file_get_contents('php://input');
// Логируем данные (временно, для отладки)
fwrite($log, "Received payload:\n$jsonPayload\n\n");

// Выполняем git pull (замените на свою команду)
$output = shell_exec('git pull origin main 2>&1');

// Логируем результат
fwrite($log, "Git pull output:\n$output\n\n");

// Закрываем файл лога
fclose($log);

echo 'Webhook received successfully';
