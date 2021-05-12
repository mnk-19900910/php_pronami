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
            $pro_name=$_POST['name'];
            $pro_price=$_POST['price'];
    
            $pro_code=htmlspecialchars($pro_code,ENT_QUOTES,'UTF-8');
            $pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
            $pro_price=htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='UPDATE mst_product SET name=?, price=?, gazou=? WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $data[]=$pro_name;
            $data[]=$pro_price;
            $data[]='';
            $data[]=$pro_code;
            $stmt->execute($data);
            // DB切断
            $dbh=null;
    
            print '修正しました。<br>';
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    <a href="pro_list.php">戻る</a>
</body>
</html>