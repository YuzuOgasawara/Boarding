<?php
$db_user = 'root';     // ユーザー名
$db_pass = 'gPByapMm7='; // パスワード
$db_name = 'bbs';     // データベース名
// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
$result_message = ':D';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['name']) && !empty($_POST['password'])) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $mysqli->query("insert into `threads` (`name`,`password`) values ('$name', '$password')");
    $result_message = 'データベースに登録しました！XD';
  } else {
    $result_message = 'メッセージを入力してください...XO';
  }
}
//データベースからレコード取得
$result = $mysqli->query('select * from `threads` order by `id` desc');
?>

<html>
  <head>
    <title> スレッド一覧</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_thread.css">
  </head>
  <body>
    <h1>スレッド投稿</h1>
    <table class="type02">
      <thead>
        <tr>
          <th><p>タイトル</p></th>
          <th><p>パスワード</p></th>
        </tr>
      </thead>
      <tbody>
        <form action="thread.php" method="post">
          <tr>
            <td><input type="text" class="type02" name="name" /></td>
            <td><input type="password" class="type02" name="password" /></td>
            <td><input type="submit" class="type03" value="投稿"/></td>
          </tr>
        </form>
      </tbody>
    </table>
    <br>
    <table class="type01">
      <thead>
        <tr>
          <th scope="cols">タイトル</th>
          <th scope="cols">時間</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $row){ ?>
          <tr>
            <td>
              <div align="left">
                <a href="entry.php?id=<?php echo $row['id']; ?>">
                  <?php print(htmlspecialchars($row['name'])); ?>
                </a>
              </div>
            </td>
            <td><?php print(htmlspecialchars($row['timestamp'])); ?></td>
            <td>
              <div class="button_wrapper">
                <form action="delete_thread.php" method="post">
                  <input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
                  <button class="button2" type="submit">削除</button>
                </form>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </body>
</html>
