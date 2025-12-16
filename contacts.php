<?php require_once 'header.php'; ?>

<h2>Контакты</h2>

<div class="card">
    <h3>Наши контакты</h3>
    <p><strong>Адрес:</strong> ул. Пушкина д 12, Москва</p>
    <p><strong>Телефон:</strong> +7 999 999 99 99</p>
    <p><strong>Email:</strong> imperial.turistik@gmail.com</p>
    
    <h4>Режим работы:</h4>
    <p>Пн-Пт: 9:00-20:00</p>
    <p>Сб-Вс: 10:00-18:00</p>
</div>

<div class="card">
    <h3>Форма обратной связи</h3>
    <form id="contactForm">
        <input type="text" placeholder="Ваше имя" required>
        <input type="tel" placeholder="Телефон" required>
        <textarea placeholder="Сообщение"></textarea>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Сообщение отправлено!');
    this.reset();
});
</script>

<?php require_once 'footer.php'; ?>