<?php
$conn = mysqli_connect('MySQL-8.0', 'root', '', 'travel_agency');
if (!$conn) die("Ошибка подключения");
mysqli_set_charset($conn, "utf8");
session_start();

function safe($text) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($text)));
}
?>