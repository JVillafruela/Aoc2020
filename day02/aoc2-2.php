<?php


$file=fopen(dirname(__FILE__). '/input2.txt','r');
if($file===false) die("error opening file");
$count=0;
$ok=0;

while (($line = fgets($file)) !== false) {
    //1-3 a: abcde
    $n = sscanf($line, "%d-%d %1s: %s\n", $min, $max, $letter, $password);
    if ($n != 4 ) continue;
    $count++;

    $i=is_letter($password,$letter,$min);
    $j=is_letter($password,$letter,$max);
    if ($i + $j == 1) {
        //print "DDD $line \n";
        $ok++;
    }
}
print("lines $count ok $ok\n");
fclose($file);


function is_letter($string,$letter,$i) {
    if ($i>strlen($string))
        return 0;

    return $string[$i-1] == $letter ? 1 : 0;
}

