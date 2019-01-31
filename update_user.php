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
$userName = $_POST["userName"];
$authority = $_POST["authority"];

$pdo = db_connect();

$sql = "UPDATE users_info SET user_name=:userName, authority=:authority WHERE id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
$stmt->bindValue(':authority', $authority, PDO::PARAM_STR);
$status = $stmt->execute();

header("Location: admin.php");
