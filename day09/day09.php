<?php


//tests(); exit();



$numbers=array();

$file=file(dirname(__FILE__). '/input9.txt',FILE_IGNORE_NEW_LINES);
foreach ($file as $i => $line) {
    $numbers[$i]=(int)$line;
}

$answer1=answer1($numbers,25); 

function answer1($numbers,$len) {
    for($i=$len;$i<count($numbers);$i++) {
        $target=$numbers[$i];
        //print "DDD [$i] $target\n";
        $ok=false;
        for($j=$i-$len;$j<$i;$j++) {
            if ($numbers[$j]>$target) continue;
            for($k=$j+1;$k<$i;$k++) {
                if ($numbers[$j]+$numbers[$k]==$target) {
                    //print "DDD   $target = $numbers[$j] + $numbers[$k] \n";
                    $ok=true;
                    break 2;
                }
            }
        }
        if ($ok==false) {
            print "DDD anser $target \n";
            return $target;
        }
    }
    return false;
}

