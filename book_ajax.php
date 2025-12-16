<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Неправильный метод запроса']);
    exit();
}

$name = safe($_POST['name']);
$phone = safe($_POST['phone']);
$email = safe($_POST['email'] ?? '');
$message = safe($_POST['message'] ?? '');

// Валидация
if (empty($name) || empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'Заполните обязательные поля']);
    exit();
}

// Здесь можно добавить отправку на почту или сохранение в базу
// Например:
// $query = "INSERT INTO applications (name, phone, email, message) 
//           VALUES ('$name', '$phone', '$email', '$message')";

// Для примера просто возвращаем успех
echo json_encode([
    'success' => true,
    'message' => 'Заявка принята! Мы свяжемся с вами в ближайшее время.'
]);
?>