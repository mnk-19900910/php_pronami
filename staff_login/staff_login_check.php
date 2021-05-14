<?php
    try {
        $staff_code=$_POST['code'];
        $staff_pass=$_POST['pass'];

        $staff_code=htmlspecialchars($staff_code,ENT_QUOTES,'UTF-8');
        $staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

        $staff_pass=md5($staff_pass);

        // DB接続
        $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
        $user='root';
        $password='';
        $dbh=new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // SQL文で司令を出す（プリペアードステートメント）
        $sql='SELECT name FROM mst_staff WHERE code=? AND password=?';
        $stmt=$dbh->prepare($sql);
        $data[]=$staff_code;
        $data[]=$staff_pass;
        $stmt->execute($data);
        // DB切断
        $dbh=null;

        $rec=$stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false){
            print 'スタッフコードかパスワードが間違えています<br>';
            print '<a href="staff_login.html">戻る</a>';
        }else{
            session_start();
            $_SESSION['login']=1;
            $_SESSION['staff_code']=$staff_code;
            $_SESSION['staff_name']=$rec['name'];
            header('Location: staff_top.php');
            exit();
        }
    }
    catch(Exception $e){
        print 'データベースの障害。<br>';
        exit();
    }
?>
