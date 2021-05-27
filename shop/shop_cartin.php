<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
    print 'ゲストログイン<br>';
    print '<a href=".member_login.html">ログイン画面へ</a><br><br>';
}else{
    print $_SESSION['member_name'];
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
            $pro_code=$_GET['procode'];
            if(isset($_SESSION['cart'])==true) {
                $cart=$_SESSION['cart']; //現在のカート内容を$cartにコピー
                $kazu=$_SESSION['kazu'];
                if(in_array($pro_code,$cart)){
                    print 'その商品はすでにカートに入っています<br>';
                    print '<a href="shop_list.php">商品一覧に戻る</a>';
                    exit();
                }
            }
            $cart[]=$pro_code; //カートに商品追加
            $kazu[]=1;
            $_SESSION['cart']=$cart; //$_SESSIONにカートを保管する
            $_SESSION['kazu']=$kazu;
        }
        catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
    カートに追加しました<br><br>
    <a href="shop_list.php">商品一覧に戻る</a>
</body>
</html>