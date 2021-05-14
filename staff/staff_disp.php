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
            $staff_code=$_GET['staffcode'];
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='SELECT code,name FROM mst_staff WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $data[]=$staff_code;
            $stmt->execute($data);
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            $staff_name=$rec['name'];
            // DB切断
            $dbh=null;
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    スタッフ情報参照<br><br>
    スタッフコード：<?php print $staff_code; ?>
    <br>
    スタッフ名：<?php print $staff_name; ?>
    <br><br>
    <input type="button" onclick="history.back()" value="戻る">

</body>
</html>