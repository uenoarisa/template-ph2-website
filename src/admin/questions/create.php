<?php
include('../../dbconnect.php');
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理画面問題作成画面</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="../assets/styles/common.css">
  <script src="../assets/scripts/common.js" defer></script>
  <script src="../assets/scripts/quiz3.js" defer></script>
</head>
<body>
  <main>
  <form action="../../services/create_question.php" method="post" enctype="multipart/form-data">
    <div class="admin-create">
      <label for="question">問題文:</label>
      <input type="text" name="content" id="question" placeholder="問題文を入力してください">
    </div>
    <div class="admin-create">
    <label class="form-label">選択肢:</label>
      <input type="text" name="choices[]" placeholder="選択肢1を入力してください">
      <input type="text" name="choices[]" placeholder="選択肢2を入力してください">
      <input type="text" name="choices[]" placeholder="選択肢3を入力してください">
    </div>
    <div class="admin-create">
      <label for="question">正解の選択肢</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice1" checked value="1">
        <label class="form-check-label" for="correctChoice1">選択肢1</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice2" value="2">
        <label class="form-check-label" for="correctChoice2">選択肢2</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice2" value="3">
        <label class="form-check-label" for="correctChoice3">選択肢3</label>
      </div>
      <div class="admin-create">
        <label for="question" class="form-label">問題の画像</label>
        <input type="file" name="image" id="image" class="form-control required" placeholder="問題文を入力してください" />
      </div>
      <div class="admin-create">
        <label for="question" class="form-label">補足:</label>
        <input type="text" name="supplement" id="supplement" class="form-control" placeholder="補足を入力してください" />
      </div>
    </div>
    <button type="submit" disabled class="btn submit">作成</button>
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