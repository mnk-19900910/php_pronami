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
            $staff_code=$_POST['code'];
            $staff_name=$_POST['name'];
            $staff_pass=$_POST['pass'];
    
            $staff_name=htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
            $staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='UPDATE mst_staff SET name=?, password=? WHERE code=?';
            $stmt=$dbh->prepare($sql);
            $data[]=$staff_name;
            $data[]=$staff_pass;
            $data[]=$staff_code;
            $stmt->execute($data);
            // DB切断
            $dbh=null;
    
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    修正しました<br><br>
    <a href="staff_list.php">戻る</a>
</body>
</html>