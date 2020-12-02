<?php
/*
$numbers=array(
    1721,
    979,
    366,
    299,
    675,
    1456
);
*/

$file=file_get_contents(dirname(__FILE__). '/input1.txt');

$numbers=explode ("\n",$file);

sort($numbers);

foreach ($numbers as $i=> $a) {
    //print("DDD a=$a\n");
    for ($j=$i;$j<count($numbers);$j++) {
        $b=$numbers[$j];
        //print("DDD     b=$b\n");
        if ($a+$b == 2020) {
            print "$a $b \n";
            exit();
        }

        if ($a+$b>2020) {
            break;
        }
    }
}
