<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1995</title>
</head>
<body>
    <?php
        $gakunen=$_POST['gakunen'];
        switch($gakunen){
            case '1': $kousha='南校舎'; break;
            case '2': $kousha='西校舎'; break;
            case '3': $kousha='東校舎'; break;
            default: $kousha='北校舎'; break;
        }
        print 'あなたの校舎は、'.$kousha.'です';
    ?>
</body>
</html>