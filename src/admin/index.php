<?php
session_start();


require_once('./login/classes/UserLogic.php');

require_once('./login/functions.php');

$result = UserLogic::checkLogin();

if(!$result){
  $_SESSION['login_err'] = 'ログインに失敗しました';
  header('Location: ./login/public/login_form.php');
  return;
}
?>

<?php
include('../dbconnect.php');
$sql = 'SELECT id, content FROM questions';
$sql_questions = 'SELECT * FROM questions';
$questions = $dbh->query($sql_questions)->fetchAll(PDO::FETCH_ASSOC);

$sql_choices = 'SELECT * FROM choices';
$choices = $dbh->query($sql_choices)->fetchAll(PDO::FETCH_ASSOC);
$is_empty = count($questions) === 0;
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理画面問題一覧</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="../assets/styles/common.css">
  <script src="../assets/scripts/common.js" defer></script>
  <script src="../assets/scripts/quiz3.js" defer></script>
</head>
<body>
  <main>
    <!-- <p>ログインユーザ:<?php echo h($login_user['name'])?>さん
    </p> -->
    <div class="admin-container">
      <h2>問題一覧</h2>
      <?php if (!$is_empty){ ?>
        <table class="quesiton-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>問題</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($questions as $question){ ?>
              <tr id="question-<?=$question["id"]?>">
                <td><?=$question["id"]?></td>
                <td>
                  <a href="./questions/edit.php?id=<?= $question["id"] ?>">
                    <?= $question["content"]; ?>
                  </a>
                </td>
                <td onclick="deleteQuestion(<?= $question['id'] ?>)"><a href="../services/delete_question.php?id=<?php echo $question['id']; ?>">削除</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else {?>
          問題がありません。
        <?php } ?>
    </div>
    <div class="admin-menu">
      <h2><a href="./questions/create.php">問題作成</a></h2>
    </div>
  </main>
</body>

