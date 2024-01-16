<?php

// Получаем данные из тела POST-запроса
$jsonPayload = file_get_contents('php://input');

// Логируем данные (временно, для отладки)
file_put_contents('/var/www/html/webhook.log', $jsonPayload . PHP_EOL, FILE_APPEND);

// Выполняем git pull (замените на свою команду)
$output = shell_exec('git pull origin main 2>&1');

// Логируем результат
file_put_contents('/var/www/html/webhook.log', $output . PHP_EOL, FILE_APPEND);

echo 'Webhook received successfully';
