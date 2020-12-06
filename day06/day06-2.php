<?php

//tests(); exit();

$count=0;
$answers='';

$file=fopen(dirname(__FILE__). '/input6.txt', 'r');
if ($file===false) {
    return false;
}

while (($line = fgets($file)) !== false) {
    $line=trim($line);
    if ($line=='') {
        $n = check_form($answers);
        //print "DDD1 $answers => $n \n";
        $count += $n;
        $answers='';
        continue;
    }
    $answers .=  $line . ' ';
}
fclose($file);
$n = check_form($answers);
//print "DDD2 $answers => $n \n";
$count += $n;

print "Answer : $count \n";



function check_form($buffer) {
    $buffer=trim($buffer);
    if($buffer=='') return 0;

    $answers=explode(' ',$buffer);
    $all=array_keys(count_chars($answers[0],1));

    for($i=1;$i<count($answers);$i++) {
        $cur = array_keys(count_chars($answers[$i],1));
        $all = array_intersect($all,$cur);
    }
    return count($all);
}


function tests() {
    assert(check_form('')==0);    
    assert(check_form('abc')==3);
    assert(check_form('a b c')==0);
    assert(check_form('ab ac')==1);
    assert(check_form('a a a a')==1);
    assert(check_form('b')==1);
}