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
            $pro_code=$_GET['procode'];
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='SELECT name,price,gazou FROM mst_product WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $data[]=$pro_code;
            $stmt->execute($data);
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            $pro_name=$rec['name'];
            $pro_price=$rec['price'];
            $pro_gazou_name=$rec['gazou'];
            // DB切断
            $dbh=null;

            if($pro_gazou_name=='') $disp_gazou='';
            else $disp_gazou='<img src="./gazou/'.$pro_gazou_name.'">';
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    商品情報参照<br><br>
    商品コード：<?php print $pro_code; ?>
    <br>
    商品名：<?php print $pro_name; ?>
    <br>
    価格：<?php print $pro_price; ?>
    <br>
    <?php print $disp_gazou; ?>
    <br><br>
    <input type="button" onclick="history.back()" value="戻る">

</body>
</html>