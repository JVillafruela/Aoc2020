<?php


//tests(); exit();

$numbers=array();

$file=file(dirname(__FILE__). '/input9.txt',FILE_IGNORE_NEW_LINES);
foreach ($file as $i => $line) {
    $numbers[$i]=(int)$line;
}

$answer1=answer1($numbers,25); 
$answer2=answer2($numbers,$answer1); 

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
            print "DDD answer $target \n";
            return $target;
        }
    }
    return false;
}

function answer2($numbers, $target) {
    $len=count($numbers);
    $ok=false;
    for ($i=0;$i<$len;$i++) {
        $sum=0;
        for ($j=$i;$j<$len;$j++) {
            $sum += $numbers[$j];
            //print("DDD $target sum[$i..$j] = $sum\n");
            if ($sum==$target) {
                $ok=true;
                break 2;
            }
        }
    }
    if($ok) {
        print("DDD found $target = sum[$i..$j] \n");
        $min=$numbers[$i];
        $max=$numbers[$i];
        for($k=$i;$k<=$j;$k++) {
            if($numbers[$k]<$min) $min=$numbers[$k];
            if($numbers[$k]>$max) $max=$numbers[$k];            
        }
        $answer2 = $min + $max;
        print("DDD min=$min max=$max answer2=$answer2\n");       
    } 
    return false;
}