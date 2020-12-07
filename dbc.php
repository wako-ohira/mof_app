<?php

function dbc()
{
  // データベース接続
  try {
    $db = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root',
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]
    );
    return $db;
  } catch(PDOException $e) {
    //例外処理
    echo 'DB接続エラー:'. $e->getMessage();
  }

}




/*
写真の保存
@param string $userName ユーザー名
@param string $filename フィアイル名
@param string $save_path 保存先のパス
@return bool $result
*/
function fileSave($userName, $filename, $save_path)
{
  $result = False;
  $sql = "INSERT INTO table_2 (user_name, file_name, file_path) VALUE (?, ?, ?)";
  
  try{
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1,$userName);
    $stmt->bindValue(2,$filename);
    $stmt->bindValue(3,$save_path);
    $result = $stmt->execute();
    return $result;    
  }catch(\Exception $e) {
    echo $e->getMessage();
    // return $result;
  }

}


/*
写真データの取得
@return array $fileData
*/
function getAllFile()
{
  $sql = "SELECT * FROM table_2";
  $fileData = dbc()->query($sql);
  return $fileData;
}


