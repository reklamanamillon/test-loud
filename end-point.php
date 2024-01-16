<?php

// Получаем данные из GET-параметра data
$data = isset($_GET['data']) ? json_decode($_GET['data'], true) : null;

if ($data === null) {
    die('Invalid data');
}

// Выполняем git pull (замените на свою команду)
$output = shell_exec('git pull origin main 2>&1');

// Логируем данные и результат выполнения команды
file_put_contents('/var/www/html/webhook.log', json_encode($data) . PHP_EOL, FILE_APPEND);
file_put_contents('/var/www/html/webhook.log', $output . PHP_EOL, FILE_APPEND);

echo 'Webhook received successfully';
?>
