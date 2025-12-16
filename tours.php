<?php
require_once 'config.php';

// Фильтр по стране
$where = '';
if (!empty($_GET['country'])) {
    $country_id = safe($_GET['country']);
    $where = "WHERE t.country_id = '$country_id'";
}

// Получение туров
$tours = mysqli_query($conn, "
    SELECT t.*, c.name as country_name 
    FROM tours t 
    JOIN countries c ON t.country_id = c.id 
    $where 
    ORDER BY t.created_at DESC
");

// Получение стран для фильтра
$countries = mysqli_query($conn, "SELECT * FROM countries");

require_once 'header.php';
?>

<h2>Все туры</h2>

<!-- Фильтр -->
<form method="GET" class="card">
    <select name="country">
        <option value="">Все страны</option>
        <?php while ($country = mysqli_fetch_assoc($countries)): ?>
            <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit" class="btn btn-primary">Фильтровать</button>
</form>

<!-- Список туров -->
<div class="grid grid-3">
    <?php while ($tour = mysqli_fetch_assoc($tours)): ?>
    <div class="card">
        <h3><?php echo $tour['title']; ?></h3>
        <p>Страна: <?php echo $tour['country_name']; ?></p>
        <p>Цена: <?php echo $tour['price']; ?> руб.</p>
        <p>Мест: <?php echo $tour['places_available']; ?></p>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="profile.php">
                <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                <button type="submit" name="book_tour" class="btn btn-primary">Забронировать</button>
            </form>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary">Войдите для бронирования</a>
        <?php endif; ?>
    </div>
    <?php endwhile; ?>
</div>

<?php require_once 'footer.php'; ?>