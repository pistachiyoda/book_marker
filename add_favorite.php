<?php

include "funcs.php";

session_start();
$bookId = $_POST["bookId"];
$userId = $_SESSION["user"];

$pdo = db_connect();

// そのユーザーがその本をお気に入りしているかどうかを判定。
// お気に入りがすでにあればなにもしない
$sql = "SELECT COUNT(*) FROM favorite WHERE user_id=:userId and book_id=:bookId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$stmt->bindValue(':bookId', $bookId, PDO::PARAM_STR);
$status = $stmt->execute();
$count = $stmt->fetchColumn();
if ($count == 1) {
$alert = <<< EOM
<script type="text/javascript">
    alert("お気に入り済みです");
    location.href="index.php";
</script>
EOM;
    echo $alert;
    return;
}

$sql = "INSERT INTO favorite (user_id, book_id) VALUES ( :userId, :bookId )";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$stmt->bindValue(':bookId', $bookId, PDO::PARAM_STR);
$status = $stmt->execute();

$addFavAlert = <<< EOM
<script type="text/javascript">
    alert("お気に入りに追加しました);
    location.href="index.php";
</script>
EOM;
echo $addFavAlert;

header("Location: favorite.php");
