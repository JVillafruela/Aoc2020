<?php

$a=read_int('input10.txt');
if ($a===false) die();

sort($a);

print_r($a);
$count=array(1=>0,3=>0);
for($i=1,$j=0;$i<count($a);$i++){
    $d=$a[$i] - $a[$i-1];
    $diff[$j++]=$d;
    $count[$d]++;
}

print_r($diff);

$count[1]++; // first adapter
$count[3]++; // last adapter
print_r($count);
$answer=$count[1]*$count[3];

print "Anwser $answer \n";


function read_int($name)
{
    $numbers=array();

    $file=file(dirname(__FILE__) .'/'. $name, FILE_IGNORE_NEW_LINES);
    if ($file===false) return false;

    foreach ($file as $i => $line) {
        $numbers[$i]=(int)$line;
    }

    return $numbers;
}

