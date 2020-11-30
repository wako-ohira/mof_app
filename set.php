<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <title>Document</title>
</head>
<body>
  <?php
  // データベース接続
  try {
    $db = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root');
  } catch(PDOException $e) {
    //例外処理
    echo 'DB接続エラー:'. $e->getMessage();
  }

  //テーブルの作成

  $sql = "CREATE TABLE IF NOT EXISTS table_1"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "email varchar(255),"
    . "create_at TIMESTAMP"
    .");";
  // SQLの実行
  $stmt = $db->query($sql);




  if(empty($_POST[name])&&empty($_POST[email])){
    $action_txt = "名前とメールアドレスを入力してください";
  }elseif(empty($_POST[name])){
    $action_txt = "名前を入力してください";
  }elseif(empty($_POST[email])){
    $action_txt = "メールアドレスを入力してください";
  }elseif(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\?\*\[|\]%'=~^\{\}\/\+!#&\$\._-])*@([a-zA-Z0-9_-])+\.([a-zA-Z0-9\._-]+)+$/", $_POST["email"])){
    $action_txt = "メールアドレスが正しくありません。";
  }else{
    // データ挿入
    $sql = $db -> prepare("INSERT INTO table_1(name, email) VALUES (:name, :email)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':email', $email, PDO::PARAM_STR);

    $name = $_POST["name"];
    $email= $_POST["email"];
    $sql -> execute();


    $action_txt = "登録しました";
  }


  // 削除機能
  //削除番号が空でない時
  if(!empty($_POST["delName"])){
    $delName=$_POST["delName"];

    $sql = 'SELECT * FROM table_1';
    $stmt = $db->query($sql);
    $results = $stmt->fetchAll();

    foreach ($results as $row){
      if($delName == $row['name']){
        $delName=$_POST["delName"];
        $sql = "delete from table_1 where name=:name";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $delName, PDO::PARAM_STR);
        $stmt->execute();
      }
    }
            
  }
  ?>
  
  <header>
  <ul class="nav justify-content-end">
      <li class="nav-item">
        <a class="nav-link" href="index.php">もどる</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
  </ul>
    
  </header>
  <main>
    <div class="container">
      <div class="top py-5"> 
        <form class="form-inline" action="" method="post" enctype="multipart/form-data" >
          <!-- 名前 -->
          <div class="form-group">
            名前：<input class="form-control mr-3" name="name" type="text" placeholder="ニックネーム">
          </div>
          <!-- メールアドレス -->
          <div class="form-group">
            メールアドレス：<input class="form-control mr-3" type="email" name="email" placeholder="メースアドレス">
          </div>
          <label>
            <span class="btn btn-outline-dark">登録<input class="form-control" type="submit" name="submit" style="display: none;"></span>
          </label>
        </form>

        
        <?php
          echo $action_txt;
          echo "<hr>";
          echo "名前を選択してください";
        ?>

        <!-- 削除フォーム -->
          <form class="form-inline mb-3" action="" method="post" enctype="multipart/form-data" >
          <div class="form-group">
            <select id="inputState" name="delName" class="form-control mr-3">
              <option selected>なまえ</option>
              <?php
              // データベース接続
              try {
                $db = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root');
              } catch(PDOException $e) {
                //例外処理
                echo 'DB接続エラー:'. $e->getMessage();
              }

              $sql = 'SELECT * FROM table_1';
              $stmt = $db->query($sql);
              $results = $stmt->fetchAll();
              
              foreach ($results as $row){
                //選択肢にtable_1のidが入る
                ?><option><?php
                echo $row['name'];
              ?></option><?php
              }
            ?>
            </select>
          </div>
          <label>
            <span class="btn btn-outline-dark mr-3">削除<input class="form-control" type="submit" name="submit" style="display: none;"></span>
          </label>
        </form>

        <?php
            echo "登録メンバー一覧"."<br>";
            // 登録者一覧の表示
            $sql = 'SELECT * FROM table_1';
            $stmt = $db->query($sql);
            $results = $stmt->fetchAll();

            foreach ($results as $row){
              echo $row['name']."　　";
              echo $row['email'];
              echo "<br>";
            }

        ?>

        <?php
        ?>
      </div>

    </div>
  </main>
  <footer></footer>
</body>
</html>