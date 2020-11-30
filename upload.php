<?php
  // データベース接続
  require_once "./dbc.php";

    $file = $_FILES["image"];
    // パスの最後の名前を返す
    $filename = basename($file['name']);
    $tmp_path = $file['tmp_name'];
    $file_err = $file['error'];
    $filesize = $file['size'];
    $userName = $_POST['userName'];
    $upload_dir = 'images/';

    // 複重を防ぐために保存する名前を変更
    $save_filename = date('YmdHis') . $filename;
    $save_path = $upload_dir. $save_filename;


    // 画像エラーの確認
    if($filesize > 1048576 || $file_err == 2){
      echo "ファイルサイズは1MB未満にしてください";
    }

    // 拡張子は画像形式か
    $allow_ext = array('jpg', 'jpeg', 'png');
      // 拡張子の取得
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
      // （拡張子を小文字に直してから）
    if(!in_array(strtolower($file_ext),$allow_ext)){
      echo '画像ファイルを選択してください';
    }elseif(empty($userName)){
      echo "名前を選択してください";
    }


    // ファイルがあるかどうか
    if(is_uploaded_file($tmp_path)){
      if(move_uploaded_file($tmp_path, $save_path)){
        // DBに保存（ユーザー名、ファイル名、ファイルパス）
        $result = fileSave($userName, $filename, $save_path);
        if ($result){
          echo "データベースに保存しました";
        }else{
          echo 'データベースへの保存が失敗しました';
        }

      }else{
        echo "ファイルが保存できませんでした";
      }

    }else{
      // echo "ファイルが選択されていません";
    }


?>
