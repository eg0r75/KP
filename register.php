<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = safe($_POST['email']);
    $password = $_POST['password'];
    $name = safe($_POST['name']);
    
    // Проверяем email
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) == 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (email, password, name) VALUES ('$email', '$hash', '$name')");
        
        // Автоматический вход
        $user_id = mysqli_insert_id($conn);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        
        header('Location: profile.php');
        exit();
    } else {
        $error = 'Email уже занят';
    }
}

require_once 'header.php';
?>

<h2>Регистрация</h2>

<?php if (isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>

<form method="POST" class="card">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="text" name="name" placeholder="Имя" required>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>

<p>Уже есть аккаунт? <a href="login.php">Войти</a></p>

<?php require_once 'footer.php'; ?>