<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'gPByapMm7='; // パスワード
$db_name = 'bbs';     // データベース名
// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
if (!empty($_POST["password"])) {
  $password = $mysqli->query("select `password` from `messages` where `messages`.`id` = {$_POST['del']} ");
  $mysqli->query("delete from `messages` where `id` = {$_POST['del']} and `messages`.`password` = '{$_POST['password']}'");
  if($mysqli->affected_rows === 0){
    $result_message = 'パスワードが違います';
  }else{
    $result_message = '削除しました:)';

    header("Location: //153.126.193.128/Boarding/entry.php?id={$_POST['thread_id']}");
  }
}

?>
<?php
$del = $_POST['del'];
$result = $mysqli->query("select * from `messages` where id = {$del}");
foreach ($result as $row){
  $delete = htmlspecialchars($row['name']);
}
?>

<html>
  <head>
    <title> 削除画面　</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_entry.css">
  </head>
  <h1>削除画面</h1>
  <body>
    <p1>以下のコメントを削除しますか？</p1>
    <p><span class="demo5"><?php echo $delete; ?></span></p>
    <form action="delete.php?id=<?php echo $_GET['id']; ?>" method="post">
      <h4><strong class="sample01"><?php echo $result_message; ?></strong></h4>
      <p>パスワード照合</p>
      <input type="password" class="type02" name="password" />
      <input type="hidden" name="del" value="<?php echo $_POST['del']; ?>" />
      <input type="hidden" name="thread_id" value="<?php echo $_GET['id']; ?>" />
      <button class="button2" type="submit">削除</button>
    </form>
    <p><a href="entry.php?id=<?php echo $_GET['id']; ?>">戻る</a></p>
  </body>
</html>
