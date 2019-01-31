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

$userId = $_GET["userId"];
$pdo = db_connect();

$sql = "SELECT * FROM users_info WHERE id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$status = $stmt->execute();
$user = $stmt->fetch();

$form = <<< EOM
<form action="update_user.php" method="POST">
    <input type="text" name="id" value="{$user["id"]}" readonly>
    <input type="text" name="userName" value="{$user["user_name"]}">
    <input type="text" name="authority" value="{$user["authority"]}">
    <button type="submit">更新</button>
</form>
<form action="delete_user.php" method="POST">
    <input type="hidden" name="id" value="{$userId}">
    <button type="submit">削除</button>
</form>
EOM;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php echo $form?>
</body>
</html>