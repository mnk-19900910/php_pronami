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
        }catch(Exception $e){
            print 'データベースの障害。<br>';
            exit();
        }
    ?>
</body>
</html>