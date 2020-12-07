<?php
require_once "./dbc.php";
$files = getAllFile();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- pickadate.js プラグイン-->
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="lib/picker.js"></script>
  <script src="lib/picker.date.js"></script>
  <script src="lib/picker.time.js"></script>
  <script src="lib/legacy.js"></script>
  <link rel="stylesheet" href="lib/themes/default.css" id="theme_base">
  <link rel="stylesheet" href="lib/themes/default.date.css" id="theme_date">
  <script src="lib/translations/ja_JP.js"></script>

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
        <!-- 写真アップロード （複数枚撰択可能）-->
        <form class="form-inline" action="index.php" method="post" enctype="multipart/form-data"> 
          <!-- 写真選択 (画像だけ撰択) -->
          <label>
            <div class="file-up">
            <input type="hidden" name="MAX/FILE_SIZE" value="1048576">
              <span class="btn btn-outline-dark mr-5" name="upload_file[]">写真を選択<input type="file" accept='image/*' name="image" onchange="loadImage(this);" multiple  style="display:none" ></span>
            </div>
          </label>
          <!-- 名前を選択 -->
          <select id="inputState" name="userName" class="form-control mr-5">
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

          <div class="row row-cols-1 row-cols-md-3">
            <?php foreach($files as $file): ?>
              <div class="col mb-4">
                <div class="card">
                  <img src="<?php echo "{$file['file_path']}" ?>" class="card-img-top" alt="...">
                  <div class="card-body">
                    <p class="card-title"><?php echo "{$file['id']}"." "."{$file['user_name']}" ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
        <div class="right col-md-4 bg-light py-3">
          <form class="form-inline">
            <div class="form-group">
              <img src="img/callender.png" class="cal_img form-control">
              <!-- type="image"  -->
              <input type="text" class="datepicker" id="date_box">
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

  </footer>
  <script type="text/javascript">
    $(function() {
      $('#date_box').pickadate({
        format: 'yyyy/mm/dd',
        disable: [
        2,4,6,8,10,12,14,16,18,20,22,24,26,28,30
        ]
      });
    });
  </script>
</body>
</html>