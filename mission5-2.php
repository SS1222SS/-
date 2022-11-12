<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-2</title>
</head>
<body>
<?php //DB接続設定
    $dsn='mysql:dbname=データベース名;host=localhost';
    $user='ユーザー名';
    $password='パスワード';
    $pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    //テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS m51"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    . "pass TEXT"
    .");";
    $stmt = $pdo->query($sql);
        $sql ='SHOW TABLES';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
    


    ?>
    
    <form action="" method="post">
    <input type="text" name="name" placeholder="名前" value="<?php 
        if(!empty($_POST["edit"])){
        $edit=$_POST["edit"];
         $passe=$_POST["passe"];
        $sql = 'SELECT * FROM m51 WHERE id='.$edit;
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($passe==$row['pass']){
        echo $row['name'];
        }}}?>"><br>
        
    <input type="text" name="com"placeholder="コメント" style="width: 163px; height: 100px;" size="21" value="<?php 
        if(!empty($_POST["edit"])){
        foreach ($results as $row){
            if($passe==$row['pass']){
        echo $row['comment'];}
        }}?>"><br>
    <input type="text" name="pass" placeholder="pass" value="<?php 
        if(!empty($_POST["edit"])){
        foreach ($results as $row){
            if($passe==$row['pass']){
        echo $row['pass'];}
        }}?>"><br>
        
    <input type="submit" name="submit"><br><br>
    <input type="teXt" name="delete" placeholder="削除番号"><br><input type="text" name="passd" placeholder="pass"><br>
    <input type="submit" value="削除"><br><br>
    <input type="teXt" name="edit" placeholder="編集対象番号"><br><input type="text" name="passe" placeholder="pass"><br>
    <input type="submit" value="編集"><br><br>
    <input type="hidden" name="editnum" value="<?php error_reporting(0);
         if($passe==$row['pass']){
         $editnum=$_POST["edit"]; echo $editnum;}?>"><hr>
</form>   
  
    <?php
     //変数名
    $filename="mission5-1.txt";
    $name = $_POST["name"];
    $com =$_POST["com"];
    $date=date("日時:Y/m/d  H:I:s")."<br>";
     if (file_exists($filename)) {
    $array = file($filename,FILE_IGNORE_NEW_LINES);
    $arrays=explode("<>",end($array));
    $num=$arrays[0]+1;
    } else {
     $num = 1;
    }
    $pass=$_POST["pass"];
    $passd=$_POST["passd"];
    $passe=$_POST["passe"];
    

   
    //初期表示
    if(empty($_POST["name"])&&empty($_POST["com"])&&empty($_POST["delete"])&&empty($_POST["edit"])&&empty($_POST["editnum"])){
    $sql = 'SELECT * FROM m51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id']."."."<br>";
        echo $row['date'];
        echo "名前:".$row['name']."<br>";
        echo $row['comment'];

    echo "<hr>";
    }
    }

//投稿フォーム
    if(empty($_POST["editnum"])){
    if(!empty($_POST["name"])){

//データ入力
    $sql = $pdo -> prepare("INSERT INTO m51 (name, comment,date,pass) VALUES (:name, :comment,:date,:pass)");
    $sql -> bindParam(':name', $dname, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $dcom, PDO::PARAM_STR);
    $sql -> bindParam(':date', $ddate, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $dpass, PDO::PARAM_STR);
    $dname = $name;
    $dcom = $com;
    $ddate=$date;
    $dpass=$pass;
    $sql -> execute();
    
//データ表示
    $sql = 'SELECT * FROM m51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id']."."."<br>";
        echo $row['date'];
        echo "名前:".$row['name']."<br>";
        echo $row['comment'];
        
    echo "<hr>";
    }
    }}
    //削除フォーム
    if(!empty($_POST["delete"])){
    $delete=$_POST["delete"];
    $id = $delete;
    //データの抽出
    $sql = 'SELECT * FROM m51 WHERE id='.$id;//削除番号のレコードを抽出
    $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
    $stmt->execute();                             // ←SQLを実行する。
    $results = $stmt->fetchAll(); 
    foreach ($results as $row){
        $row['pass'];//抽出したレコードのpassカラムを選択
    }
    //パスワード実装
    if($passd==$row['pass']){
    $sql = 'delete from m51 where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    //表示
    $sql = 'SELECT * FROM m51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id']."."."<br>";
        echo $row['date'];
        echo "名前:".$row['name']."<br>";
        echo $row['comment'];
        echo "<hr>";
    }
    }else{
            echo "パスワードが違います"."<hr>";
    $sql = 'SELECT * FROM m51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id']."."."<br>";
        echo $row['date'];
        echo "名前:".$row['name']."<br>";
        echo $row['comment'];
        echo "<hr>";
        }}}
    //編集フォーム1、編集番号のレコードを表示
    if(!empty($_POST["edit"])){
        $edit=$_POST["edit"];
        $sql = 'SELECT * FROM m51 WHERE id='.$edit;//編集番号のレコードを抽出
    $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
    $stmt->execute();                             // ←SQLを実行する。
    $results = $stmt->fetchAll(); 
    foreach ($results as $row){
        $row['pass'];}
    //パスワードが違う場合
    if($passe!=$row['pass']){
    $sql = 'SELECT * FROM m51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id']."."."<br>";
        echo $row['date'];
        echo "名前:".$row['name']."<br>";
        echo $row['comment'];
        echo "<hr>";}
    echo "パスワードが違います"."<hr>";
    }
    //パスワードがあってる場合
    if($passe==$row['pass']){
         $sql = 'SELECT * FROM m51';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id']."."."<br>";
        echo $row['date'];
        echo "名前:".$row['name']."<br>";
        echo $row['comment'];
        echo "<hr>";}
    }}
    
    //編集フォーム2
    if(!empty($_POST["editnum"])){
        $editnum=$_POST["editnum"];
        $id = $editnum; //変更する投稿番号
        $name = $_POST["name"];
        $comment = $_POST["com"];
        $pass = $_POST["pass"];
        $sql = 'UPDATE m51 SET name=:name,comment=:comment,pass=:pass WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        //表示
        $sql = 'SELECT * FROM m51';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id']."."."<br>";
        echo $row['date'];
        echo "名前:".$row['name']."<br>";
        echo $row['comment'];
    echo "<hr>";
    }
    }
        
    ?>

</body>
</html>