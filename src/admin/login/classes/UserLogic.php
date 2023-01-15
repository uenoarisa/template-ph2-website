<?php

require_once dirname(__FILE__).'/../dbconnect-login.php';

class UserLogic
{
  /**
   * ユーザを登録する
   * @param array $userData 引数
   * @return bool $result
   */
  public static function createUser($userData)
  {
    $result = false;
    $sql = 'INSERT INTO users (name, email,password) VALUES (?,?,?)'; //?はプレースホルダー後で入れられる


    //ユーザデータを配列に入れる

    $arr = [];
    $arr[] = $userData['username']; //name　フォームのusernameに入れられた値を入れる
    $arr[] = $userData['email']; //email
    $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT); //password

    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    } catch (\Exception $e) {
      return $result;
    }
  }
  /**
   * ログイン処理
   * @param string $email
   * @param string $password
   * @return bool $result
   */
  public static function login($email, $password)
  {
    //結果
    $result = false;
    // ユーザをemailから検索して取得
    $user = self::getUserByEmail($email);
    //自分と同じメゾット内のロジック

    if (!$user) {
      $_SESSION['msg'] = 'emailが一致しません';
      return $result;
    }

    //パスワードの照会
    if (password_verify($password, $user['password'])) {
      //ログイン成功
      session_regenerate_id(true);
      // セッションidを新たなものと入れ替える
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    }
    $_SESSION['msg'] = 'パスワードが一致しません';
  }
  /**
   * emailからユーザを取得
   * @param string $email
   * @return array|bool $user|false
   */
  public static function getUserByEmail($email)
  {
    //sqlの準備
    //sqlの実行
    //sqlの結果を返す
    $sql = 'SELECT * FROM users WHERE email = ?';

    //emailを配列に入れる
    $arr = [];
    $arr[] = $email;
    try {
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);
      //sqlの結果を返す。詳細版②prepare⇒③bindValue⇒④execute
      //簡易版 query
      $user = $stmt->fetch();
      return $user;
    } catch (\Exception $e) {
      return false;
    }

  }

  /**
   * ログインチェック
   * @paramvoid
   * @return bool $result
   */
  public static function checkLogin()
  {
    $result = false;

    //セッションにログインユーザが入っていなかったらfalse
    if (isset($_SESSION['login_user']) && ($_SESSION['login_user']['id']) > 0) {
      return $result = true;
    }
    return $result;
  }
  /**
   * ログアウト処理
   */
  public static function logout(){
    $_SESSION = array();
    session_destroy();
  }
}