<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'gPByapMm7='; // パスワード
$db_name = 'bbs';     // データベース名
$result_message="";
// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
//メッセージとパスワードに値がはいっているとき
if (!empty($_POST["message"]) && !empty($_POST["password"])) {
  $result = $mysqli->query("update `messages` set `body` = '{$_POST['message']}' where `messages`.`id` = {$_POST['user_id']} and `messages`.`password` = '{$_POST['password']}'");
  if($mysqli->affected_rows === 0){
    $result_message = 'パスワードが違います';
  }else{
    $result_message = '編集しました:)';
    header("Location: //153.126.193.128/Boarding/entry.php?id={$_POST['thread_id']}");
  }
}
?>
<?php
$id = $_POST['user_id'];
$result = $mysqli->query("select * from `messages` where id = {$id}");
foreach ($result as $row){
  $edit = htmlspecialchars($row['name']);
}
?>

<html>
  <head>
    <title>編集画面</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_entry.css">
  </head>
  <body>
    <h1>編集画面</h1>
    <p1>前に登録したコメント</p1>
    <p><span class="demo6"><?php echo $edit; ?></span></p>
    <form action="update.php?id=<?php echo $_GET['id']; ?>" method="post">
  <!--新しいコメントと前画面で入力したパスワードを入力-->
      <p1>コメント入力</p1>
      <br>
      <input type="text" class="type02" name="message" />
      <br>
      <br>
      <h4><strong class="sample01"><?php echo $result_message; ?></strong></h4>
      <p1>パスワード照合</p1>
      <br>
      <input type="password" class="type02" name="password" />
      <input type="hidden" name="user_id" value="<?php echo $_POST['user_id']; ?>" />
      <input type="hidden" name="thread_id" value="<?php echo $_GET['id']; ?>" />
      <button class="button1" type="submit">編集</button>
    </form>
    <p><a href="entry.php?id=<?php echo $_GET['id']; ?>">戻る</a></p>
  </body>
</html>
