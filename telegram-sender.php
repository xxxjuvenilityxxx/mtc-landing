<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $botToken = '8067615220:AAE4nHwZp_mvWzr8BXQyWSqx8KtkDIWYbZc';
    $chatId = '-1002795685673';
    
    // Получаем и очищаем данные
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    
    // Формируем сообщение
    $message = "📬 Новая заявка:\n"
        . "👤 Имя: $name\n"
        . "📱 Телефон: $phone\n"
        . "⏰ " . date('d.m.Y H:i:s');

    // Отправка в Telegram
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
    
    if ($result === FALSE) {
        echo json_encode(['success' => false, 'error' => 'Send error']);
    } else {
        echo json_encode(['success' => true]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>