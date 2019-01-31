<?php
require_once "funcs.php";
session_start();
if ($_SESSION['admin']) {
    # echo "ろぐいんできました";
} else {
    # echo "ろぐいんできません";
    header("Location: login.php");
    return;
}

$userName = $_POST["userName"];
$authority = $_POST["authority"];

$pdo = db_connect();

$sql = "INSERT INTO users_info (user_name, authority) VALUES ( :userName, :authority )";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
$stmt->bindValue(':authority', $authority, PDO::PARAM_STR);
$status = $stmt->execute();

header("Location: admin.php");
