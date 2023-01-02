<?php
try {
  include('../dbconnect.php');
 
  $content = $_POST['content'];
  $choices = $_POST['choices'];
  $supplement = $_POST['supplement'];
  $correctChoice = $_POST['correctChoice'];
  $image_name = uniqid(mt_rand(), true);
  //ファイル名をユニーク化
  $image_name .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
  //アップロードされたファイルの拡張子を取得 ＊_FILES[inputで指定したname]['name']=>ファイル名
  $image_path=dirname(__FILE__). '/../assets/img/quiz/' . $image_name;
  // dirname(__FILE__)は今いるディレクトリの絶対パス
  move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
 
  $sqlinsert = "INSERT INTO questions ( content, image, supplement) VALUES ( :content, :image, :supplement)"; // テーブルに登録するINSERT INTO文を変数に格納　VALUESはプレースフォルダーで空の値を入れとく
  //データベースを取得
  $stmt = $dbh->prepare($sqlinsert); //値が空のままSQL文をセット
  $params = array(':content' => $content, ':image' => $image_name, ':supplement' => $supplement); // 挿入する値を配列に格納
  $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

  $sqlinsert = "INSERT INTO choices (name, valid, question_id) VALUES ( :name, :valid, :question_id)";
  $lastInsertId = $dbh->lastInsertId();

  $stmt = $dbh->prepare($sqlinsert);
  for ($i=0; $i < count($choices); $i++){
    $params = array(':name' => $choices[$i], ':valid' => (int)$correctChoice === $i + 1 ? 1:0, ':question_id' => $lastInsertId);
    $stmt->execute($params);
  }
  header("Location: ". "http://localhost:8080/admin/index.php");
  echo '<p>上記の内容をデータベースへ登録しました。</p>';
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
