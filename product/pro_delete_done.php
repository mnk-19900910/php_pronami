<?php include '../session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1995</title>
</head>
<body>
    <?php
        try {
            $pro_code=$_POST['code'];
            $pro_gazou_name=$_POST['gazou_name'];
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='DELETE FROM mst_product WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $data[]=$pro_code;
            $stmt->execute($data);
            // DB切断
            $dbh=null;
            if($pro_gazou_name!='') unlink('./gazou/'.$pro_gazou_name);
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    削除しました<br><br>
    <a href="pro_list.php">戻る</a>
</body>
</html>