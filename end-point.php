<?php

// Получаем данные из тела POST-запроса
$jsonPayload = file_get_contents('php://input');

// Логируем данные (временно, для отладки)
file_put_contents('/var/www/html/webhook.log', $jsonPayload . PHP_EOL, FILE_APPEND);

// Получаем секретный ключ из настроек вебхука
$secret = '123'; // Замените на ваш реальный секретный ключ

// Проверка наличия секретного токена
if (isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    $hubSignature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
    list($algo, $hash) = explode('=', $hubSignature, 2);

    // Вычисляем хеш из тела запроса и секретного ключа
    $payloadHash = hash_hmac($algo, $jsonPayload, $secret);

    // Сравниваем хеши
    if ($hash === $payloadHash) {
        // Если хеши совпадают, выполняем git pull
        $output = shell_exec('git pull origin main 2>&1');
        // Логируем результат
        file_put_contents('/var/www/html/webhook.log', 'Git pull output:' . PHP_EOL . $output . PHP_EOL, FILE_APPEND);
        echo 'Webhook received and git pull executed successfully';
    } else {
        // В случае неверного секрета, возвращаем ошибку
        header('HTTP/1.1 403 Forbidden');
        echo 'Invalid secret';
    }
} else {
    // Если заголовок X-Hub-Signature отсутствует, возвращаем ошибку
    header('HTTP/1.1 400 Bad Request');
    echo 'X-Hub-Signature header missing';
}
?>
