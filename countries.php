<?php
require_once 'config.php';

$countries = mysqli_query($conn, "
    SELECT c.*, COUNT(t.id) as tours_count 
    FROM countries c 
    LEFT JOIN tours t ON c.id = t.country_id 
    GROUP BY c.id 
    ORDER BY c.name
");

require_once 'header.php';
?>

<h2>Страны</h2>

<div class="grid grid-3">
    <?php while ($country = mysqli_fetch_assoc($countries)): ?>
    <div class="card">
        <h3><?php echo $country['name']; ?></h3>
        <p><?php echo $country['description']; ?></p>
        <p>Туров: <?php echo $country['tours_count']; ?></p>
        <a href="tours.php?country=<?php echo $country['id']; ?>" class="btn btn-primary">Смотреть туры</a>
    </div>
    <?php endwhile; ?>
</div>

<?php require_once 'footer.php'; ?>