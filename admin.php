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

$userId = $_SESSION["user"];
$pdo = db_connect();

$sql = "SELECT * FROM users_info";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
$users = $stmt->fetchAll();

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
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ユーザー名</th>
                <th>権限</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ( $users as $user) {
$tr = <<< EOM
<tr>
    <td>{$user["id"]}</td>
    <td>{$user["user_name"]}</td>
    <td>{$user["authority"]}</td>
    <td><a href="user.php?userId={$user["id"]}">編集</a></td>
</tr>
EOM;
echo $tr;
    }
?>
        </tbody>
    </table>
    
</body>
</html>