<?php
include('../../dbconnect.php');
$sql = 'SELECT id, content FROM questions WHERE id = :id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$question = $stmt->fetch();

$sql = "SELECT * FROM choices WHERE question_id = :question_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":question_id", $_REQUEST["id"]);
$stmt->execute();
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理画面問題更新画面</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="../assets/styles/common.css">
  <script src="../assets/scripts/common.js" defer></script>
  <script src="../assets/scripts/quiz3.js" defer></script>
</head>
<body>
  <main>
  <form action="../../services/update_question.php" method="POST" enctype="multipart/form-data">
    <div class="admin-create">
      <label for="question">問題文:</label>
      <input type="text" name="content" id="question" value="<?= $question["content"] ?>" placeholder="問題文を入力してください">
    </div>
    <div class="admin-create">
    <label class="form-label">選択肢:</label>
      <?php foreach($choices as $key => $choice){ ?>
        <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢を入力してください" value=<?= $choice["name"] ?>>
      <?php } ?>
    </div>
    <div class="admin-create">
      <label for="question">正解の選択肢</label>
      <?php foreach ($choices as $key => $choice){ ?>
        <div class="formcheck">
          <input type="radio" name="correctChoice" id="correctChoice<?= $key ?>" <?= $choice["valid"] === 1 ? 'checked' : '' ?>>
        <label class="form-check-label" for="correctChoice1">選択肢<?= $key + 1 ?>
        </label>
        </div>
      <?php } ?>
      
      <div class="admin-create">
        <label for="question" class="form-label">問題の画像</label>
        <input type="file" name="image" id="image" class="form-control required" placeholder="問題の画像をアップロードしてください" />
      </div>
      <div class="admin-create">
        <label for="question" class="form-label">補足:</label>
        <input type="text" name="supplement" id="supplement" class="form-control" placeholder="補足を入力してください" value="<?=$question["id"]?>"/>
      </div>
    </div>
    <input type="hidden" name="question_id" value="<?= $question["id"] ?>">
    <button type="submit" class="btn submit">更新</button>
    <!-- disabledがあるとそのbutton要素は無効になる。 -->
  </form>
  </main>
  <script>
    const submitButton = document.querySelector('.btn.submit')
    const inputDoms = Array.from(document.querySelectorAll('.required'))
    inputDoms.forEach(inputDom => {
      inputDom.addEventListener('input', event => {
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        submitButton.disabled = !isFilled
      })
    })
  </script>
</body>