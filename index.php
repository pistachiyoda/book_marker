<?php
session_start();
if ($_SESSION['loggedIn'] == true) {
    # echo "ろぐいんできました";
} else {
    # echo "ろぐいんできません";
    header("Location: login.php");
}

$requestUrl = "https://www.googleapis.com/books/v1/volumes?q=%E6%84%9B&key=AIzaSyCYByZrKmrrwMC28TpSF7wEUFktSvm0unE";
$booksData = file_get_contents($requestUrl);
$encodedBooksData = json_decode($booksData);

include "funcs.php";

$userId = $_SESSION["user"];
$pdo = db_connect();

$sql = "SELECT user_name FROM users_info WHERE id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$status = $stmt->execute();
$user = $stmt->fetch();
$userName = $user["user_name"];

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <title>メインページ</title>
    </head>
    <body>
        <div id="allWrapper">
            <div id="sideWrapper">
                <div>ユーザー：<?php echo $userName ?></div>
                <ul>
                    <li><a href="index.php">TOP</a></li>
                    <li><a href="favorite.php">FAVORITE</a></li>
                    <li><a href="admin.php">ADMIN</a></li>
                </ul>
            </div>
            <div id="mainWrapper">
                <header>
                    <h1>Book Marker</h1>
                </header>
                <h2>Fukuda's Recommendation!!</h1>
                <div class="recoWrapper">
<?php
foreach($encodedBooksData->items as $item) {
    $bookImg = $item->volumeInfo->imageLinks->thumbnail;
    $bookTitle = $item->volumeInfo->title;
    $bookPreview = $item->volumeInfo->previewLink;
    $bookId = $item->id;
    $bookHtml = <<< EOM
<div>
    <div class="book">
        <div class="favDelBtn">
            <form method="post" action="add_favorite.php">
                <input type="hidden" name="bookId" value="{$bookId}">
                <button type="submit"><i class="fab fa-gratipay favBtnDetail fa-2x"></i></button>
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