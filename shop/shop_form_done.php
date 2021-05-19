<?php
    session_start();
    session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1995</title>
</head>
<body>
    <?php
        try{
            require_once('../common/common.php');

            $post=sanitize($_POST);
            $onamae=$post['onamae'];
            $email=$post['email'];
            $postal1=$post['postal1'];
            $postal2=$post['postal2'];
            $address=$post['address'];
            $tel=$post['tel'];
            $ok=true;
    
            print $onamae.'様<br>';
            print 'ご注文ありがとうございました。<br>';
            print $email.'　にメールを送りましたのでご確認ください。<br>';
            print '商品は以下の住所に発送いたします。<br>';
            print $postal1.'-'.$postal2.'<br>';
            print $address.'<br>';
            print $tel.'<br>';
            
            $honbun='';
            $honbun.=$onamae."様\n\nこの度はご注文ありがとうございました。\n";
            $honbun.="\n";
            $honbun.="ご注文商品\n";
            $honbun.="----------------------\n";

            $cart=$_SESSION['cart'];
            $kazu=$_SESSION['kazu'];
            $max=count($cart);
            $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
            $user='root';
            $password='';
            $dbh=new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            // mst_product表に商品情報を保存する
            for($i=0;$i<$max;$i++){
                $sql='SELECT name,price FROM mst_product WHERE code=?';
                $stmt=$dbh->prepare($sql);
                $data[0]=$cart[$i];
                $stmt->execute($data);
                $rec=$stmt->fetch(PDO::FETCH_ASSOC);
                $name=$rec['name'];
                $price=$rec['price'];
                $kakaku[]=$price;
                $suryo=$kazu[$i];
                $shokei=$price*$suryo;
                $honbun.=$name.' '.$price.'円 x '.$suryo.'個 = '.$shokei."円 \n";
            }

            // dat_sales表に注文データを保存する
            $sql='INSERT INTO dat_sales(code_member,name,email,postal1,postal2,address,tel) VALUES(?,?,?,?,?,?,?)';
            $stmt=$dbh->prepare($sql);
            $data=array();
            $data[]=0;
            $data[]=$onamae;
            $data[]=$email;
            $data[]=$postal1;
            $data[]=$postal2;
            $data[]=$address;
            $data[]=$tel;
            $stmt->execute($data);

            // dat_sales_product表に商品詳細を追加する
            $sql='SELECT LAST_INSERT_ID()'; //AUTO_INCREMENTで直近に発番された番号を取得
            $stmt=$dbh->prepare($sql);
            $stmt->execute($data);
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            $lastcode=$rec['LAST_INSERT_ID()']; //取得した注文コードを$lastcodeに格納

            for($i=0;$i<$max;$i++){
                $sql='INSERT INTO dat_sales_product(code_sales,code_product,price,quantity) VALUES(?,?,?,?)';
                $stmt=$dbh->prepare($sql);
                $data=array();
                $data[]=$lastcode;
                $data[]=$cart[$i];
                $data[]=$kakaku[$i];
                $data[]=$kazu[$i];
                $stmt->execute($data);
            }
            $dbh=null;

            // お客様へのメール本文
            $honbun.="送料は無料です。\n";
            $honbun.="----------------------\n\n";
            $honbun.="代金は以下の口座にお振込みください。\n";
            $honbun.="A銀行 B支店 普通口座１２３４５６７\n";
            $honbun.="入金確認後、発送いたします。\n\n";
            $honbun.="**************************\n";
            $honbun.="〜マッツアカデミー〜\n\n";
            $honbun.="福岡県福岡市中央区唐人町１−２−３\n";
            $honbun.="電話 090-1234-5678\n";
            $honbun.="メール info@mattuacademy.co.jp\n";
            $honbun.="**************************\n";

            // メール内容をブラウザで確認
            // print '<br>';
            // print nl2br($honbun);

            // お客様へのメール送信
            $title=$onamae.'様　ご注文ありがとうございます。';
            $header='From:info@mattuacademy.co.jp';
            $honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail($email,$title,$honbun,$header);

            // お店へのメール送信
            $title='お客様からご注文がありました。';
            $header='From:'.$email;
            $honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail('info@mattuacademy.co.jp',$title,$honbun,$header);


        }catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
</body>
</html>