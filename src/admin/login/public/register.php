<?php
session_start();
require_once '../classes/UserLogic.php';


//エラーメッセージ
$err = [];

$token = filter_input(INPUT_POST, 'csrf_token');

// トークンがないもしくは一致しない場合に処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
  exit('不正なリクエストです');
}

unset($_SESSION['csrf_token']);

// バリデーション
if(!$username = filter_input(INPUT_POST, 'username')){
  $err[]='ユーザ名を記入してください';
}
if(!$username = filter_input(INPUT_POST, 'email')){
  $err[]='メールアドレスを記入してください';
}
$password = filter_input(INPUT_POST, 'password');
// 正規表現
if (!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)){
  $err[] = 'パスワードは英数字８文字以上100文字以下にしてください';
}
$password_conf = filter_input(INPUT_POST,'password_conf');

if ($password != $password_conf){
  $err[] = '確認用パスワードが一致していません';
  $err[] = $password;
  $err[] =$password_conf;
}
if (count($err)===0){
  // ユーザ登録する処理 UserLogicっていうクラスに静的なメゾット
  $hasCreated = UserLogic::createUser($_POST);
  if(!$hasCreated){
    $err[] = '登録に失敗しました。';
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザ登録完了画面</title>
</head>
<body>
  <?php if (count($err) > 0 ): ?>
    <?php foreach($err as $e): ?>
      <p><?php echo $e ?></p>
    <?php endforeach ?>
  <?php else: ?>
    <p>ユーザ登録が完了しました</p>
  <?php endif ?>
  <a href="./signup_form.php">戻る</a>
  
</body>
</html>