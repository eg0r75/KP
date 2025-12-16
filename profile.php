<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Бронирование тура
if (isset($_POST['book_tour'])) {
    $tour_id = safe($_POST['tour_id']);
    mysqli_query($conn, "INSERT INTO user_tours (user_id, tour_id) VALUES ($user_id, $tour_id)");
    mysqli_query($conn, "UPDATE tours SET places_available = places_available - 1 WHERE id = $tour_id");
}

// Получение туров пользователя
$bookings = mysqli_query($conn, "
    SELECT ut.*, t.title, t.price, t.start_date, c.name as country_name 
    FROM user_tours ut 
    JOIN tours t ON ut.tour_id = t.id 
    JOIN countries c ON t.country_id = c.id 
    WHERE ut.user_id = $user_id 
    ORDER BY ut.booking_date DESC
");

// Доступные туры
$tours = mysqli_query($conn, "
    SELECT t.*, c.name as country_name 
    FROM tours t 
    JOIN countries c ON t.country_id = c.id 
    WHERE t.places_available > 0 
    ORDER BY t.start_date
");

require_once 'header.php';
?>

<h2>Личный кабинет</h2>
<p>Добро пожаловать, <?php echo $_SESSION['user_name']; ?>!</p>

<h3>Мои бронирования</h3>
<?php while ($booking = mysqli_fetch_assoc($bookings)): ?>
    <div class="card">
        <h4><?php echo $booking['title']; ?></h4>
        <p><?php echo $booking['country_name']; ?></p>
        <p>Цена: <?php echo $booking['price']; ?> руб.</p>
        <p>Дата: <?php echo date('d.m.Y', strtotime($booking['start_date'])); ?></p>
    </div>
<?php endwhile; ?>

<h3>Доступные туры</h3>
<?php while ($tour = mysqli_fetch_assoc($tours)): ?>
    <div class="card">
        <h4><?php echo $tour['title']; ?></h4>
        <p><?php echo $tour['country_name']; ?></p>
        <p>Цена: <?php echo $tour['price']; ?> руб.</p>
        <p>Мест: <?php echo $tour['places_available']; ?></p>
        <form method="POST">
            <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
            <button type="submit" name="book_tour" class="btn btn-primary">Забронировать</button>
        </form>
    </div>
<?php endwhile; ?>

<p><a href="logout.php">Выйти</a></p>

<?php require_once 'footer.php'; ?>