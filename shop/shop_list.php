<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
    print 'ゲストログイン<br>';
    print '<a href="member_login.html">ログイン画面へ</a><br><br>';
}else{
    print $_SESSION['staff_name'];
    print 'さんログイン中<br><br>';
    print '<a href="member_logout.html">ログアウト</a><br><br>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1995</title>
</head>
<body>
    <?php
        try {
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // SQL文で司令を出す（プリペアードステートメント）
            $sql='SELECT code,name,price FROM mst_product WHERE 1';
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            // DB切断
            $dbh=null;
    
            while(true){
                $rec=$stmt->fetch(PDO::FETCH_ASSOC);
                if($rec==false) break;
                print '<a href="shop_product.php?procode='.$rec['code'].'">';
                print $rec['name'].'：';
                print $rec['price'].'円';
                print '</a>';
                print '<br>';
            }
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
        print '<br>';
        print '<a href="shop_cartlook.php">カートを見る</a><br>';
    ?>
</body>
</html>