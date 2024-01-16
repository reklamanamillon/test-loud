<?php

// Выполняем git pull с опцией --no-rebase (замените на свою команду)
$output = shell_exec('git pull origin main --no-rebase 2>&1');

// Логируем результат
file_put_contents('/var/www/html/webhook.log', 'Git pull output:' . PHP_EOL . $output . PHP_EOL, FILE_APPEND);

echo 'Webhook received and git pull executed successfully';
?>
