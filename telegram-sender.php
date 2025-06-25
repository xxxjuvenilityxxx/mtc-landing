<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $botToken = '8067615220:AAE4nHwZp_mvWzr8BXQyWSqx8KtkDIWYbZc';
    $chatId = '-1002795685673';
    
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    
    $message = "📬 Новая заявка с сайта:\n\n"
        . "👤 Имя: $name\n"
        . "📱 Телефон: $phone\n\n"
        . date('Y-m-d H:i:s');
    
    // URL без параметров в строке запроса
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    // Детальная обработка ошибок
    if ($result === FALSE) {
        $error = error_get_last();
        echo "Ошибка отправки: " . $error['message'];
    } else {
        $response = json_decode($result, true);
        if ($response['ok']) {
            echo "Сообщение отправлено! ID: " . $response['result']['message_id'];
        } else {
            echo "Ошибка Telegram: " . $response['description'];
        }
    }
}
?>