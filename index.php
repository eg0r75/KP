<?php require_once 'header.php'; ?>

<h2>Добро пожаловать в Imperial Turistik!</h2>
<p>Найдите свой идеальный тур</p>

<div class="card">
    <h3>Поиск туров</h3>
    <form action="tours.php" method="GET">
        <select name="country">
            <option value="">Выберите страну</option>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM countries");
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?>
        </select>
        <input type="date" name="date">
        <button type="submit" class="btn btn-primary">Найти</button>
    </form>
</div>

<div class="card">
    <h3>Популярные туры</h3>
    <div class="grid grid-3">
        <?php
        $result = mysqli_query($conn, "SELECT t.*, c.name as country_name FROM tours t JOIN countries c ON t.country_id = c.id LIMIT 3");
        while ($tour = mysqli_fetch_assoc($result)) {
            echo '<div class="card">';
            echo '<h4>'.$tour['title'].'</h4>';
            echo '<p>'.$tour['country_name'].'</p>';
            echo '<p>'.$tour['price'].' руб.</p>';
            echo '<a href="tour.php?id='.$tour['id'].'" class="btn btn-primary">Подробнее</a>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<?php require_once 'footer.php'; ?>