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

    $n=count_letter($password,$letter);
    if ($min <= $n && $n <= $max)
        $ok++;
}
print("lines $count ok $ok\n");
fclose($file);


function count_letter($string,$letter) {
    $chars=count_chars($string, 1);

    if (!array_key_exists(ord($letter) , $chars))
        return 0;

    return $chars[ord($letter)];
}

