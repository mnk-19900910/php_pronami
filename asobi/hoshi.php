<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1995</title>
</head>
<body>
    <?php
        $mbango=$_POST['mbango'];
        $hoshi['M1']='カニ星雲';
        $hoshi['M31']='アンドロメダ大星雲';
        $hoshi['M42']='オリオン大星雲';
        $hoshi['M45']='昴';
        $hoshi['M57']='ドーナツ星雲';
        foreach($hoshi as $key => $val){
            print $key.'は'.$val.'<br>';
        }
        print 'あなたが選んだ星は、'.$hoshi[$mbango].'です';
    ?>
</body>
</html>