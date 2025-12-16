<?php
require_once 'config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: index.php');
    exit();
}

// Добавление тура
if (isset($_POST['add_tour'])) {
    $title = safe($_POST['title']);
    $price = safe($_POST['price']);
    $country_id = safe($_POST['country_id']);
    mysqli_query($conn, "INSERT INTO tours (title, price, country_id) VALUES ('$title', '$price', '$country_id')");
}

// Получение данных
$tours = mysqli_query($conn, "SELECT t.*, c.name as country_name FROM tours t JOIN countries c ON t.country_id = c.id");
$countries = mysqli_query($conn, "SELECT * FROM countries");
$users = mysqli_query($conn, "SELECT * FROM users");

require_once 'header.php';
?>

<h2>Админ-панель</h2>

<h3>Добавить тур</h3>
<form method="POST" class="card">
    <input type="text" name="title" placeholder="Название тура" required>
    <input type="number" name="price" placeholder="Цена" required>
    <select name="country_id" required>
        <option value="">Выберите страну</option>
        <?php while ($country = mysqli_fetch_assoc($countries)): ?>
            <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit" name="add_tour" class="btn btn-primary">Добавить</button>
</form>

<h3>Все туры</h3>
<?php while ($tour = mysqli_fetch_assoc($tours)): ?>
    <div class="card">
        <p><?php echo $tour['title']; ?> (<?php echo $tour['country_name']; ?>) - <?php echo $tour['price']; ?> руб.</p>
    </div>
<?php endwhile; ?>

<h3>Пользователи</h3>
<?php while ($user = mysqli_fetch_assoc($users)): ?>
    <div class="card">
        <p><?php echo $user['name']; ?> (<?php echo $user['email']; ?>)</p>
    </div>
<?php endwhile; ?>

<?php require_once 'footer.php'; ?>