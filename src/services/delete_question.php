<?php
 
try {
    // DB接続
    $dsn = 'mysql:dbname=posse;host=db';
    $user = 'root';
    $password = 'root';

    $dbh = new PDO($dsn, $user, $password);
    $delete_id = $_GET['id']; 
    $sql = "DELETE FROM choices WHERE question_id = :question_id";
    $stmtt = $dbh->prepare($sql);
    $stmtt->bindValue(":question_id", $delete_id);
    $stmtt->execute();
  
     // SQL文をセット
    $stmt = $dbh->prepare('DELETE FROM questions WHERE id = :id');

    // 値をセット
    $stmt->bindValue(':id', $delete_id);
  
     // SQL実行
    $stmt->execute();
    header('Location: ../admin/index.php');
    exit();
  
} catch (PDOException $e) {
     // エラー発生
     echo $e->getMessage();
      
 } finally {
     // DB接続を閉じる
     $pdo = null;
 }
  
 ?>
 