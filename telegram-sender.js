document.querySelector('form').addEventListener('submit', async (e) => {
  e.preventDefault();
  
  const botToken = '8067615220:AAE4nHwZp_mvWzr8BXQyWSqx8KtkDIWYbZc';
  const chatId = '-1002795685673';
  
  const name = document.getElementById('name').value;
  const phone = document.getElementById('phone').value;
  
  const message = `📬 Новая заявка:%0A👤 Имя: ${name}%0A📱 Телефон: ${phone}`;
  
  const url = `https://api.telegram.org/bot${botToken}/sendMessage?chat_id=${chatId}&text=${message}`;
  
  try {
    await fetch(url);
    alert('Данные отправлены!');
    e.target.reset();
  } catch (error) {
    alert('Ошибка отправки');
  }
});