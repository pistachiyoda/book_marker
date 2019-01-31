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

$userId = $_POST["id"];

$pdo = db_connect();

$sql = "DELETE FROM users_info WHERE id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$status = $stmt->execute();

header("Location: admin.php");
