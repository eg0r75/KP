<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imperial Turistik</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; }
        
        /* Шапка */
        header { background: #065EE3; color: white; padding: 10px 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .header-top { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: bold; }
        
        /* Навигация */
        nav { background: white; padding: 10px 0; }
        .nav-links { display: flex; gap: 20px; }
        .nav-links a { color: #333; text-decoration: none; padding: 8px 15px; }
        .nav-links a:hover { background: #f0f5ff; color: #065EE3; }
        
        /* Кнопки */
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #065EE3; color: white; }
        .btn-outline { background: white; border: 2px solid #065EE3; color: #065EE3; }
        
        /* Модальное окно */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal form { background: white; padding: 20px; border-radius: 10px; width: 90%; max-width: 400px; }
        .modal input, .modal textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        
        /* Основной контент */
        main { min-height: 60vh; padding: 20px 0; }
        
        /* Подвал */
        footer { background: #2c3e50; color: white; margin-top: 40px; padding: 30px 0; }
        .footer-content { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
        
        /* Карточки */
        .card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        .grid { display: grid; gap: 20px; }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        
        /* Сообщения */
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 10px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .grid-3 { grid-template-columns: 1fr; }
            .nav-links { flex-wrap: wrap; }
            .footer-content { flex-direction: column; }
        }
    </style>
</head>
<body>
    <!-- Модальное окно -->
    <div id="bookModal" class="modal">
        <form id="bookingForm">
            <h3>Оставить заявку</h3>
            <input type="text" name="name" placeholder="Имя" required>
            <input type="tel" name="phone" placeholder="Телефон" required>
            <textarea name="message" placeholder="Сообщение"></textarea>
            <button type="submit" class="btn btn-primary">Отправить</button>
            <button type="button" onclick="closeModal()" class="btn">Закрыть</button>
        </form>
    </div>

    <!-- Шапка -->
    <header>
        <div class="container">
            <div class="header-top">
                <div class="logo">Imperial Turistik</div>
                <div>
                    <span>ул. Пушкина д 12</span> | 
                    <span>+7 999 999 99 99</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Навигация -->
    <nav>
        <div class="container">
            <div class="nav-links">
                <a href="index.php">Главная</a>
                <a href="countries.php">Страны</a>
                <a href="tours.php">Туры</a>
                <a href="feedback.php">Отзывы</a>
                <a href="company.php">О компании</a>
                <a href="contacts.php">Контакты</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">Личный кабинет</a>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <a href="admin.php">Админ</a>
                    <?php endif; ?>
                    <a href="logout.php">Выйти</a>
                <?php else: ?>
                    <a href="login.php">Войти</a>
                    <a href="register.php">Регистрация</a>
                <?php endif; ?>
                
                <button onclick="openModal()" class="btn btn-primary">Заявка</button>
            </div>
        </div>
    </nav>

    <main class="container">