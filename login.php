<?php
include "funcs.php";

$userName = $_POST["userName"];

$pdo = db_connect();

// その名前のユーザー名がDBにあるかを確認

$sql = "SELECT * FROM users_info WHERE user_name=:userName";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
$status = $stmt->execute();
$user = $stmt->fetch();
$id = $user["id"];
$authority = $user["authority"];

if ($user == false) {
    echo '
    <script type="text/javascript">
        alert("ユーザー名が間違っています");
        location.href="login_form.php";
    </script>
    ';
} else {
    session_start();
    $_SESSION['loggedIn'] = true;
    $_SESSION['user'] = $id;
    $_SESSION['admin'] = $authority == "admin";
    header("Location: index.php");
    exit;
}
?>