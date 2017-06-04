<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'gPByapMm7='; // パスワード
$db_name = 'bbs';     // データベース名
// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$result_message = ':D';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['name']) && !empty($_POST['message']) && !empty($_POST['password'])) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $message = $mysqli->real_escape_string($_POST['message']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $id = $_POST['thread_id'];
    $mysqli->query("insert into `messages` (`name`,`body`,`password`,`thread_id`) values ('$name', '$message', '$password',$id)");
    $result_message = 'データベースに登録しました！XD';

  } else {
    $result_message = 'メッセージを入力してください...XO';
  }
  if (!empty($_POST['del'])) {
    $mysqli->query("delete from `messages` where `id` = {$_POST['del']}");
    $result_message = 'メッセージを削除しました;)';
  }
}
//データベースからレコード取得
$id = $_GET['id'];
$result = $mysqli->query("select * from `threads` inner join `messages` on `threads`.`id` = `messages`.`thread_id` where `threads`.`id` = {$id} order by `messages`.`id` desc");
$result2 = $mysqli->query("select * from `threads` where id = {$id}");
foreach ($result2 as $row){
  $thread_name = htmlspecialchars($row['name']);
}
?>

<html>
  <head>
    <title> 掲示板　</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_entry.css">
  </head>
  <h1><?php echo $thread_name; ?></h1>
  <body>
    <table class="type02">
      <thead>
        <tr>
          <th><p>名前</p></th>
          <th><p>コメント</p></th>
          <th><p>パスワード</p></th>
        </tr>
      </thead>
      <tbody>
        <form action="" method="post">
          <tr>
            <td><input type="text" class="type02" name="name" /></td>
            <td><input type="text" class="type02" name="message" /></td>
            <td><input type="password" class="type02" name="password" /></td>
            <td>
              <input type="hidden" name="thread_id" value="<?php echo $_GET['id']; ?>" />
              <input type="submit" class="type03" value="投稿"/>
            </td>
          </tr>
        </form>
      </tbody>
    </table>
    <br>
    <table class="type01">
      <thead>
        <tr>
          <th scope="cols">名前</th>
          <th scope="cols">コメント</th>
          <th scope="cols">時間</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $row){ ?>
        <tr>
          <td><?php print(htmlspecialchars($row['name'])); ?></td>
          <td><?php print(htmlspecialchars($row['body'])); ?></td>
          <td><?php print(htmlspecialchars($row['timestamp'])); ?></td>
          <td>
            <form action="delete.php?id=<?php echo $_GET['id']; ?>" method="post">
              <input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
              <button class="button2" type="submit">削除</button>
            </form>
          </td>
          <td>
            <form action="update.php?id=<?php echo $_GET['id']; ?>" method="post">
              <input type="hidden" name="upd" value="<?php echo $row['id']; ?>" />
              <button class="button1" type="submit">編集</button>
            </form>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <p><a href="thread.php">戻る</a></p>
  </body>
</html>
