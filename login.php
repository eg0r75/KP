<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = safe($_POST['email']);
    $password = $_POST['password'];
    
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            header('Location: profile.php');
            exit();
        }
    }
    $error = 'Неверный email или пароль';
}

require_once 'header.php';
?>

<h2>Вход</h2>

<?php if (isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>

<form method="POST" class="card">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>

<p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>

<?php require_once 'footer.php'; ?>