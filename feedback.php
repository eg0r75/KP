<?php
require_once 'config.php';

// Добавление отзыва
if (isset($_SESSION['user_id']) && isset($_POST['add_feedback'])) {
    $text = safe($_POST['text']);
    $author = $_SESSION['user_name'];
    mysqli_query($conn, "INSERT INTO feedback (author, text, user_id) VALUES ('$author', '$text', {$_SESSION['user_id']})");
}

// Получение отзывов
$feedbacks = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");

require_once 'header.php';
?>

<h2>Отзывы</h2>

<?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" class="card">
        <textarea name="text" placeholder="Ваш отзыв" rows="3" required></textarea>
        <button type="submit" name="add_feedback" class="btn btn-primary">Добавить отзыв</button>
    </form>
<?php else: ?>
    <p><a href="login.php">Войдите</a>, чтобы оставить отзыв</p>
<?php endif; ?>

<?php while ($feedback = mysqli_fetch_assoc($feedbacks)): ?>
    <div class="card">
        <h4><?php echo $feedback['author']; ?></h4>
        <p><?php echo $feedback['text']; ?></p>
        <small><?php echo date('d.m.Y', strtotime($feedback['created_at'])); ?></small>
    </div>
<?php endwhile; ?>

<?php require_once 'footer.php'; ?>