<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1995</title>
</head>
<body>
    <?php
        try {
            $pro_code=$_GET['procode'];
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='SELECT code,name FROM mst_product WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $data[]=$pro_code;
            $stmt->execute($data);
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            $pro_name=$rec['name'];
            // DB切断
            $dbh=null;
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    商品削除<br><br>
    商品コード<br>
    <?php print $pro_code; ?><br>
    商品名<br>
    <?php print $pro_name; ?><br>
    この商品を削除してよろしいですか？<br>
    <br><br>
    <form method="post" action="pro_delete_done.php">
        <input type="hidden" name="code" value="<?php print $pro_code; ?>">
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>

</body>
</html>