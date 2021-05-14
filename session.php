<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
    print 'ログインされていません。<br>';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}else{
    print $_SESSION['staff_name'];
    print 'さんログイン中<br><br>';
}
?>