<?php
include "funcs.php";

$userName = $_POST["registerName"];
echo $userName;
$authority = "general";
$dateTime = date("Y/m/d H:i:s");

$pdo = db_connect();

$sql = "INSERT INTO users_info(user_name,authority,datetime)VALUES(:userName,:authority,:dateTime)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
$stmt->bindValue(':authority', $authority, PDO::PARAM_STR);
$stmt->bindValue(':dateTime', $dateTime, PDO::PARAM_STR);

$status = $stmt->execute();

if ($status == false) {
    sqlError($stmt);
} else {
    header("Location: index.php");
    exit;
}
?>