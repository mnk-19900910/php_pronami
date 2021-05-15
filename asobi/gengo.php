<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1995</title>
</head>
<body>
    <?php
        require_once('../common/common.php');
        $seireki=$_POST['seireki'];
        $wareki=gengo($seireki);
        print $wareki;
        ?>
</body>
</html>