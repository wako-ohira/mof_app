<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <title>Document</title>
  <script src="js/preview.js"></script>
</head>
<body>
  <header>
    <ul class="nav justify-content-end">
      <li class="nav-item">
        <a class="nav-link active" href="set.php">設定</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
    </ul>

  </header>
  <main>
    <div class="container">
      <div class="top py-3"> 
        <!-- 写真アップロード -->
        <form class="form-inline" action="index.php" method="post" enctype="multipart/form-data"> 
          <!-- 写真選択 -->
          <label>
            <span class="btn btn-outline-dark mr-5" name="upload_file[]">写真を選択<input type="file" accept='image/*' name="image" onchange="loadImage(this);" multiple  style="display:none" ></span>
          </label>
          <!-- 名前を選択 -->
          <select id="inputState" name="name" class="form-control mr-5">
            <option selected>名前を選択</option>
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
                //選択肢にtable_1のnameが入る
                ?><option><?php
                echo $row['name'];
              ?></option><?php
              }
            ?>
          <!-- 登録 -->
          </select>
              <label>
            <span class="btn btn-outline-dark">登録<input class="form-control" type="submit" style="display: none;"></span>
          </label>
        </form>
      <?php require("upload.php"); ?>
      </div>
   
    </div>
    <div class="container">
      <div class="row">
        <div class="left col-md-8">

        <!-- プレビューを表示 -->
        <br>
        <p id="preview"></p> 
        <hr>

        </div>

        <div class="right col-md-4 bg-light py-3">
          <!-- <img class="cal_img" src="/img/callender.png" alt=""> -->
          <form class="form-inline">
            <div class="form-group">
              <input type="image" src="img/callender.png" class="cal_img form-control">
            </div>
            <div class="row">
              <div class="col-md-2 form-group">
                <input type="text" class="form-control w-20" placeholder="番号">
              </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </main>
  <footer>
  <?php
  // echo $_POST["name"];
  // echo $_FILES["image"]["name"];
  ?>
  </footer>
</body>
</html>