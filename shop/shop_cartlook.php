<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
    print 'ゲストログイン<br>';
    print '<a href=".member_login.html">ログイン画面へ</a><br><br>';
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
            if(isset($_SESSION['cart'])==true){
                $cart=$_SESSION['cart'];
                $kazu=$_SESSION['kazu'];
                $max=count($cart);
            }else $max=0;
            // var_dump($cart);
            // var_dump($kazu);
            // exit();
            if($max==0){
                print 'カートに商品が入っていません<br><br>';
                print '<a href="shop_list.php">商品一覧へ戻る</a>';
                exit();
            }
            // DB接続
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            foreach($cart as $key=>$val){
                $sql='SELECT code,name,price,gazou FROM mst_product WHERE code=?';
                $stmt=$dbh->prepare($sql);
                $data[0]=$val;
                $stmt->execute($data);

                $rec=$stmt->fetch(PDO::FETCH_ASSOC);

                $pro_name[]=$rec['name'];
                $pro_price[]=$rec['price'];
                if($rec['gazou']=='') $pro_gazou[]='';
                else $pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
            }
            $dbh=null;
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    カートの中身<br><br>
    <form method="post" action="kazu_change.php">
        <table border="1">
            <tr>
                <td>商品</td>
                <td>商品画像</td>
                <td>価格</td>
                <td>数量</td>
                <td>小計</td>
                <td>削除</td>
                <?php for($i=0;$i<$max;$i++){ ?>
            </tr>
        <tr>
            <td><?php      print $pro_name[$i]; ?></td>
            <td><?php      print $pro_gazou[$i]; ?></td>
            <td><?php      print $pro_price[$i]; ?>円</td>
            <td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
            <td>合計：<?php print $pro_price[$i]*$kazu[$i]; ?>円</td>
            <td>削除<input type="checkbox" name="sakujo<?php print $i; ?>"></td>
        </tr>
        <?php } ?>
        </table>
        <input type="hidden" name="max" value="<?php print $max; ?>">
        <input type="submit" value="数量変更"><br>    
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>
</html>