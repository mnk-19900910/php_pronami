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
            require_once('../common/common.php');

            $post=sanitize($_POST);
            $pro_name=$post['name'];
            $pro_price=$post['price'];
            $pro_gazou_name=$post['gazou_name'];
    
            $pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
            $pro_price=htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='INSERT INTO mst_product(name,price,gazou) VALUES (?,?,?)';
            $stmt=$dbh->prepare($sql);
            $data[]=$pro_name;
            $data[]=$pro_price;
            $data[]=$pro_gazou_name;
            $stmt->execute($data);
            // DB切断
            $dbh=null;
    
            print $pro_name;
            print 'を追加しました。<br>';
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    <a href="pro_list.php">戻る</a>
</body>
</html>