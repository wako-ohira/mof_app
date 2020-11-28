<?php
  // データベース接続
  try{
    $db = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root');
  } catch(PDOException $e) {
    //例外処理
    echo 'DB接続エラー:'. $e->getMessage();
  }

  //テーブルの作成

  $sql = "CREATE TABLE IF NOT EXISTS table_2"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "image mediumblob,"
    . "uploaded_at DATETIME"
    .");";
  // SQLの実行
  $stmt = $db->query($sql);


  if(!empty($_FILES[image])&&!empty($_POST[name])){
    // データ挿入
    $upload = $db -> prepare("INSERT INTO table_2(name, image) VALUES (:name, :image)");
    $upload -> bindParam(':name', $name, PDO::PARAM_STR);
    $upload -> bindParam(':image', $image, PDO::PARAM_STR);

    $name = $_POST["name"];
    $image = $_FILES["image"];
    $upload -> execute();

    echo "アップロードしました";
  }

  


?>
