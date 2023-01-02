<?php
/* ドライバ呼び出しを使用して MySQL データベースに接続する */
$dsn = 'mysql:dbname=posse;host=db';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);
// new PDO('hostの名前'、'データベースのユーザ名'、'データベースのパスワード','使用するデータベース名')
// $sql = 'SELECT id, content FROM questions';

// $sql_questions = 'SELECT * FROM questions';
// $questions = $dbh->query($sql_questions)->fetchAll(PDO::FETCH_ASSOC);

// $sql_choices = 'SELECT * FROM choices';
// $choices = $dbh->query($sql_choices)->fetchAll(PDO::FETCH_ASSOC);

?>