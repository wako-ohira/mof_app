<?php
  require("index.php");
  // データベース接続
  try {
    $db = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root');
  } catch(PDOException $e) {
    //例外処理
    echo 'DB接続エラー:'. $e->getMessage();
  }


  // テーブルの作成
  $sql_2 = "CREATE TABLE IF NOT EXISTS $table_2"
  ." ("
  . "id INT AUTO_INCREMENT PRIMARY KEY,"
  . "name char(32),"
  . "image mediumblob,"
  . "uploaded_at DATETIME"
  .");";
  $stmt_2 = $db->query($sql_2);


  // データの挿入
  $sql_2 = $db -> prepare("INSERT INTO table_2(name_2, image) VALUES (:name_2, :image)");
  $sql_2 -> bindParam(':name_2', $name_2, PDO::PARAM_STR);
  $sql_2 -> bindParam(':image', $image, PDO::PARAM_STR);

  $name_2 = $_POST["name_2"];
  $image = $_POST["image"];
  $sql_2 -> execute();





?>