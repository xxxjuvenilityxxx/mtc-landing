// Функция для отправки данных в Telegram
function sendDataToTelegram(formData) {
    const botToken = '8067615220:AAGOt8E8CQvjhj__ksZnrtXEHureHCN9Zj8'; // Токен вашего бота
    const chatId = '7228650776'; // ID получателя (пользователя)
    const apiUrl = `https://web.telegram.org/k/#@Mtcqwiz_bot`; // URL для отправки сообщения

    // Формируем сообщение в формате HTML
    const message = `
📩 Вам новая заявка:
<b>Имя:</b> ${formData.name}
<b>Телефон:</b> ${formData.phone}




    `;

    // Параметры, которые будем отправлять
    const params = {
        chat_id: chatId, // ID чата
        text: message, // Текст сообщения
        parse_mode: 'HTML' // Режим парсинга HTML
    };

    // Отправляем данные с помощью fetch API
    return fetch(apiUrl, {
        method: 'POST', // Метод отправки
        headers: {
            'Content-Type': 'application/json', // Указываем тип содержимого
        },
        body: JSON.stringify(params) // Преобразуем параметры в JSON
    }).then(response => response.json()); // Возвращаем ответ в формате JSON
}

// Обработчик события отправки формы
form.addEventListener('submit', (e) => {
    e.preventDefault(); // Отменяем стандартное поведение формы
    if (validateForm()) { // Проверяем форму на валидность
        const formData = { // Собираем данные из формы
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            birthDate: document.getElementById('birthDate').value,
            gender: document.querySelector('input[name="gender"]:checked').value,
            hobbies: Array.from(hobbiesCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.nextElementSibling.textContent),
            notes: document.getElementById('notes').value
        };

        // Показать состояние загрузки
        modal.innerHTML = '<div class="modal-content"><p>Отправка данных...</p></div>';
        modal.style.display = 'block';

        // Отправляем данные в Telegram
        sendDataToTelegram(formData)
            .then(result => {
                if (result.ok) {
                    // Если данные успешно отправлены
                    modal.innerHTML = '<div class="modal-content"><p>Ваша анкета успешно отправлена</p></div>';
                } else {
                    // Если произошла ошибка при отправке
                    modal.innerHTML = '<div class="modal-content"><p>Ошибка при отправке анкеты. Пожалуйста, попробуйте еще раз.</p></div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Обработка ошибки
                modal.innerHTML = '<div class="modal-content"><p>Произошла ошибка. Пожалуйста, попробуйте позже.</p></div>';
            })
            .finally(() => {
                // Закрываем модальное окно и сбрасываем форму через 3 секунды
                setTimeout(() => {
                    modal.style.display = 'none';
                    form.reset(); // Сброс формы
                    updateHobbiesButton(); // Обновляем текст кнопки хобби
                }, 3000);
            });
    }
});