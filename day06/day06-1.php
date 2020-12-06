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
    $answers .=  $line;
}
fclose($file);
$n = check_form($answers);
print "DDD2 $answers => $n \n";
$count += $n;

print "Answer : $count \n";



function check_form($answers) {
    if($answers=='') return 0;

    $count=count_chars($answers,1);
    return count($count);
}

function tests() {
    assert(check_form('')==0);    
    assert(check_form('abc')==3);
    assert(check_form('abac')==3);
    assert(check_form('aaaa')==1);
    assert(check_form('b')==1);
}