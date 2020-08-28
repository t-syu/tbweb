<!DOCTYPE html>
<head>
    <meta charset = "UTF-8">
    <title>mission3_5</title>
</head>
<body>
    <?php
        //データベースへの接続
        $dsn = 'mysql:dbname=**********;host=localhost';
        $user = '*********';
        $password = '**********';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //CREATE文：データベース内にテーブルを作成
        $sql = "CREATE TABLE IF NOT EXISTS mission3_5"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "date TEXT"
        .");";
        $stmt = $pdo->query($sql);
        
        //phpのPOSTを取得
        $name = $_POST["name"];
        $cmt = $_POST["cmt"];
        $dele = $_POST["dele"];
        $edit = $_POST["edit"];
        $id = $_POST["id"];
        $sbm_pw = $_POST["sbm_pw"];
        $dele_pw = $_POST["dele_pw"];
        $edit_pw = $_POST["edit_pw"];
        $date = date("Y年m月d日H時i分s秒");
        
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(isset($_POST["sbm_btn"])) {
                if($id) {
                    $dbid = $id; //変更する投稿番号
                    $dbname = $name; //変更したい名前、変更したいコメントは自分で決めること
                    $dbcmt = $cmt; 
                    $dbdate = $date; 
                    $sql = 'UPDATE mission3_5 SET name=:name,comment=:comment,date=:date WHERE id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $dbname, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $dbcmt, PDO::PARAM_STR);
                    $stmt->bindParam(':date', $dbdate, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $dbid, PDO::PARAM_INT);
                    $stmt->execute();
                }else {
                    if ($name && $cmt && $sbm_pw === "pass") {
                        //データを入力（データレコードの挿入）
                        $sql = $pdo -> prepare("INSERT INTO mission3_5 (name, comment, date) VALUES (:name,:comment,:date)");
                        $sql -> bindParam(':name', $dbname, PDO::PARAM_STR);
                        $sql -> bindParam(':comment', $dbcmt, PDO::PARAM_STR);
                        $sql -> bindParam(':date', $dbdate, PDO::PARAM_STR);
                        $dbname = $name;
                        $dbcmt = $cmt;
                        $dbdate = $date;
                        $sql -> execute();
                        }
                }    
                
            }elseif(isset($_POST["dele_btn"])) {
                if($dele && $dele_pw === "pass") {
                $dbid = $dele;
                $sql = 'delete from mission3_5 where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $dbid, PDO::PARAM_INT);
                $stmt->execute();
                }
                
            }elseif(isset($_POST["edit_btn"])) {
                if ($edit && $edit_pw === "pass") {
                    $sql = 'SELECT * FROM mission3_5';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        if($row['id'] === $edit) {
                            $editname=$row['name'];
                            $editcmt=$row['comment'];
                        }else {
                            // echo "error";
                        }
	}
                }    
            }      
        }
    ?>
<form action = "" method = "post">
    <input type = "hidden" name = "id" value = "<?=$edit?>">
    <br>
    <h5>  [投稿フォーム]</h5>
    名前:       <input type = "text" name = "name" value = "<?=$editname?>">
    <br>
    コメント:   <input type = "text" name = "cmt" value = "<?=$editcmt?>">
    <br>
    パスワード: <input type = "password" name = "sbm_pw">
    <button type = "submit" name ="sbm_btn">送信</button>
    <br>
    <h5> [削除フォーム]</h5>
    削除番号:   <input type = "text" name = "dele">
    <br>
    パスワード: <input type = "password" name = "dele_pw">
    <button type = "submit" name ="dele_btn">削除</button>
    <br>
    <h5> [編集フォーム]</h5>
    編集番号:   <input type = "text" name = "edit">
    <br>
    パスワード: <input type = "password" name = "edit_pw">
    <button type = "submit" name ="edit_btn">編集</button>
</form>
    <?php
    echo "<br> <hr>";
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        if(isset($_POST["sbm_btn"])) {
            if($name) {
                
            }else {
                echo "<font color='red'><br> ------  Error: Name is empty  ------ <br></font>";
            }
            if($cmt) {
                
            }else {
                echo "<font color='red'><br> ------  Error: Comment is empty  ------ <br></font>";
            }
            if($sbm_pw === 'pass') {
                
            }else {
                echo "<font color='red'><br> ------  Error: Password is not correct  ------ <br></font>";
            }
        }elseif (isset($_POST["dele_btn"])) {
            if($dele) {
                
            }else {
                echo "<font color='red'><br> ------  Error: Delete Number is empty  ------ <br></font>";
            }
            if($dele_pw === 'pass') {
                
            }else {
                echo "<font color='red'><br> ------  Error: Password is not correct  ------ <br></font>";
            }    
        }elseif (isset($_POST["edit_btn"])) {
            if($edit) {
                
            }else {
                echo "<font color='red'><br> ------  Error: Edit Number is empty  ------ <br></font>";
            }
            if($edit_pw === 'pass') {
                
            }else {
                echo "<font color='red'><br> ------  Error: Password is not correct  ------ <br></font>";
            }
        }else {
            
        }
        echo "<br> <hr> <br>";
        echo " [投稿一覧] <br><br>";
	//SELECT文：入力したデータレコードを抽出し、表示する
	$sql = 'SELECT * FROM mission3_5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['date'].'<br>';
	}
    }
    ?>
</body>