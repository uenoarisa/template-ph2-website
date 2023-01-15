<?php
session_start();
require_once '../classes/UserLogic.php';

require_once '../functions.php';

//ログインしているか判定してしていなかったら新規登録画面へ移す。
$result = UserLogic::checkLogin();

if (!$result){
  $_SESSION['login_err'] = 'ユーザを登録してください。';
  header('Location: signup_form.php');
  return;
}

$login_user = $_SESSION['login_user'];


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
</head>
<body>
  <h2>管理者マイページ</h2>
  <p>ログインユーザ:<?php echo $login_user['name']?></p>
  <p>メールアドレス:<?php echo $login_user['email']?></p>

  <a href="./login.php">戻る</a>
  <a href="../../index.php">管理画面問題一覧へ</a>

  <form action="logout.php" method="POST">
    <input type="submit" name="logout" value="ログアウト">
  </form>
</body>
</html>