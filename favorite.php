<?php

require_once('funcs.php');
session_start();
if ($_SESSION['loggedIn'] == true) {
    # echo "ろぐいんできました";
} else {
    # echo "ろぐいんできません";
    header("Location: login.php");
}


$userId = $_SESSION["user"];
$pdo = db_connect();

$sql = "SELECT user_name FROM users_info WHERE id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$status = $stmt->execute();
$user = $stmt->fetch();
$userName = $user["user_name"];

// そのユーザーがその本をお気に入りしているかどうかを判定。
// お気に入りがすでにあればなにもしない
$userId = $_SESSION["user"];
$sql = "SELECT book_id FROM favorite WHERE user_id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$status = $stmt->execute();
$favoriteData = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <title>お気に入り</title>
    </head>
    <body>
        <div id="allWrapper">
            <div id="sideWrapper">
                <div>ユーザー：<?php echo $userName ?></div>
                <ul>
                    <li><a href="index.php">TOP</a></li>
                    <li><a href="favorite.php">FAVORITE</a></li>
                </ul>
            </div>
            <div id="mainWrapper">
                <header>
                    <h1>Book Marker</h1>
                </header>
                <h2>Favorite!!</h1>
                <div class="recoWrapper">
<?php
foreach($favoriteData as $favorite) {
    $bookId = $favorite["book_id"];
    $requestUrl = "https://www.googleapis.com/books/v1/volumes/{$bookId}?key=AIzaSyCYByZrKmrrwMC28TpSF7wEUFktSvm0unE";
    $booksData = file_get_contents($requestUrl);
    $encodedBooksData = json_decode($booksData);
    $bookImg = $encodedBooksData->volumeInfo->imageLinks->thumbnail;
    $bookTitle = $encodedBooksData->volumeInfo->title;
    $bookPreview = $encodedBooksData->volumeInfo->previewLink;
    $bookId = $encodedBooksData->id;
    $bookHtml = <<< EOM
<div>
    <div class="book">
        <div class="favDelBtn">
            <form method="post" action="delete_favorite.php">
                <input type="hidden" name="bookId" value="{$bookId}">
                <button type="submit"><i class="fas fa-times-circle DelBtnDetail fa-2x"></i></button>
            </form>
        </div>

        <a href="{$bookPreview}" class="bookImgTitle">
            <img src="{$bookImg}">
            <h1 class="bookTitle">{$bookTitle}</h1>
        </a>
    </div>
</div>
EOM;
    echo $bookHtml;
}
?>
                </div>
            </div>
        </div>
    </body>
</html>