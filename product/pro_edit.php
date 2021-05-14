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
            $pro_gazou_name_old=$rec['gazou'];
            // DB切断
            $dbh=null;

            if($pro_gazou_name_old=='') $disp_gazou='';
            else $disp_gazou='<img src="./gazou/'.$pro_gazou_name_old.'">';
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    商品修正<br><br>
    商品コード<br>
    <?php print $pro_code; ?>
    <br><br>
    <form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
        <input type="hidden" name="code" value="<?php print $pro_code; ?>">
        <input type="hidden" name="gazou_name_old" value="<?php print $pro_gazou_name_old; ?>">
        商品名<br>
        <input type="text" name="name" style="width:200px" value="<?php print $pro_name; ?>"><br>
        価格<br>
        <input type="text" name="price" style="width:50px" value="<?php print $pro_price; ?>">円<br>
        <br>
        <?php print $disp_gazou; ?>
        <br>
        画像をえらんでください<br>
        <input type="file" name="gazou" style="width:400px"><br>
        <br>
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>

</body>
</html>