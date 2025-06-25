<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $botToken = '8067615220:AAE4nHwZp_mvWzr8BXQyWSqx8KtkDIWYbZc'; // Замените на ваш токен
    $chatId = '-1002795685673'; // Замените на ваш chat ID
    
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    
    $message = "📬 Новая заявка с сайта:\n\n"
        . "👤 Имя: $name\n"
        . "📱 Телефон: $phone\n\n"
        . date('Y-m-d H:i:s');
    
    $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&$message";
    
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
        echo "Ошибка отправки!";
    } else {
        echo "Сообщение отправлено!";
    }
}
?>