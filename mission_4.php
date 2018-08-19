<?php
header('Content-Type: text/html; charset=UTF-8');
//テーブルへ接続
try {
  $dsn = 'mysql:dbname=データベース名;host=localhost';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password,
array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}
//テーブル作成
$sql = "CREATE TABLE mission_4"
."("
. "id INT PRIMARY KEY,"
. "name TEXT,"
. "comment TEXT,"
. "day TEXT,"
. "namecomepass TEXT"
.");";
$stmt = $pdo->query($sql);
//データ入力(入力データ受け取り)
$name = $_POST["name"];
$comment = $_POST["comment"];
$delete= $_POST["delete"];
$edit= $_POST["edit"];
$hensyuu = $_POST["hensyuu"];
$editname = $_POST["editname"];
$editcomment = $_POST["editcomment"];
$namecomepass = $_POST["namecomepass"];
$deletepass = $_POST["deletepass"];
$editpass = $_POST["editpass"];
$id_max = intval($pdo->query("SELECT max(id) FROM mission_4")->fetchColumn());
//データ入力
if(empty($name)){
}else{
  if(empty($comment)){
  }else{
    if(empty($namecomepass)){
      }else{
      $sql = $pdo -> prepare("INSERT INTO mission_4 (id, name, comment, day, namecomepass) VALUES (:id, :name, :comment, :day, :namecomepass)");
      $sql -> bindvalue(':id', $id = $id_max +1, PDO::PARAM_INT);
      $sql -> bindParam(':name', $name, PDO::PARAM_STR);
      $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
      $sql -> bindParam(':day', date("Y年n月d日H時i分s秒"), PDO::PARAM_STR);
      $sql -> bindParam(':namecomepass', $namecomepass, PDO::PARAM_STR);
      $sql -> execute();
    }
  }
}

//データ削除
if(empty($delete)){
}else{
  $stmt = $pdo -> prepare("DELETE FROM mission_4 WHERE id = :id AND namecomepass = :namecomepass");
  $stmt -> bindValue(':id', $delete, PDO::PARAM_INT);
  $stmt -> bindParam(':namecomepass', $deletepass, PDO::PARAM_STR);
  $stmt -> execute();
}

//データ編集(編集したい番号の送信)
if(empty($edit) and empty($editpass)){
}else{
  if(empty($hensyuu)){
  $stmt = $pdo -> prepare("SELECT * FROM mission_4 WHERE id = :id AND namecomepass = :namecomepass");
  $stmt -> bindValue(':id', $edit, PDO::PARAM_INT);
  $stmt -> bindParam(':namecomepass', $editpass, PDO::PARAM_STR);
  $stmt -> execute();
   if ($rows = $stmt -> fetch()) {
         $name1 = $rows["name"];
         $comment1 = $rows["comment"];
}
}
}

//データ編集（本番）
if(empty($hensyuu) and empty($editname) and empty($editcomment)){
}else{
  $stmt = $pdo -> prepare("UPDATE mission_4 SET name =:name, comment=:comment, day=:day WHERE id = :id");
  $stmt-> bindParam(':name', $editname, PDO::PARAM_STR);
  $stmt-> bindParam(':comment', $editcomment, PDO::PARAM_STR);
  $stmt-> bindParam(':day', date("Y年n月d日H時i分s秒"), PDO::PARAM_STR);
  $stmt-> bindValue(':id', $hensyuu, PDO::PARAM_INT);
  $stmt-> execute();
}
?>


<html>
<head>
<title>tanaka mission_4.php</title>
<meta http-equiv="content-type" charset="utf-8">
<body>
<!--fromタグで入力フォームを表示。actionにデータ送信先、methodにデータ送信方法(ここではPOSTを利用）-->
<form action = "mission_4.php" method="post">
<!--inputタグにtypeにtextを指定すると、1行の入力フィールドを表示する。valueで指定した語句が入力フィールドに表示される-->
名前：<input type="text" name="name">
<br/>
コメント：<input type="text" name="comment" >
<br/>
パスワード：<input type="text" name="namecomepass">
<!--inputタグのtypeにsubmitを指定すると、データ送信ボタンを表示する。valueで指定した語句がボタンに表示する-->
<input type="submit" value="送信">
<br/>
<br/>
<!--inputタグのtypeにtextを指定すると、１行の入力フィールドを表示する。valueで指定した語句が入力フィールドに表示される-->
削除対象番号:<input type="text" name="delete">
<br/>
パスワード：<input type="text" name="deletepass">
<!--inputタグのtypeにsubmitを指定すると、データ送信ボタンを表示する。valueで指定した語句がボタンに表示する-->
<input type="submit" value="削除">
<br/>
<br/>
<!--inputタグのtypeにtextを指定すると、１行の入力フィールドを表示する。valueで指定した語句が入力フィールドに表示される-->
編集対象番号:<input type="text" name="edit">
<br/>
パスワード：<input type="text" name="editpass">
<br/>
名前(編集用)：<input type="text" name="editname" value="<?php echo "$name1"; ?>">
<br/>
コメント（編集用）：<input type="text" name="editcomment" value="<?php echo "$comment1"; ?>">
<!--編集したい番号-->
<input type="hidden" name="hensyuu" value="<?php echo "$edit"; ?>">
<!--inputタグのtypeにsubmitを指定すると、データ送信ボタンを表示する。valueで指定した語句がボタンに表示する-->
<input type="submit" value="編集">
</form>
</body>
</html>


<?php
header('Content-Type: text/html; charset=UTF-8');
//テーブルへ接続
try {
  $dsn = 'mysql:dbname=データベース名;host=localhost';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password,
array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}
//データ表示
$sql = 'SELECT * FROM mission_4 ORDER BY id';
$results = $pdo -> query($sql);
foreach ($results as $row){
//$rowの中にはテーブルのカラム名が入る
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
echo $row['day'].'<br>';
}
?>
