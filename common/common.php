<?php
    function gengo($seireki){
        if($seireki>=1868 && $seireki<=1911) $gengo='明治';
        if($seireki>=1912 && $seireki<=1925) $gengo='大正';
        if($seireki>=1926 && $seireki<=1988) $gengo='昭和';
        if($seireki>=1989 && $seireki<=2018) $gengo='平成';
        if($seireki>=2019) $gengo='令和';
        return($gengo);
    }

    function sanitize($before){
        foreach($before as $key=>$value){
            $after[$key]=htmlspecialchars($value, ENT_QUOTES,'UTF-8');
        }
        return $after;
    }
?>