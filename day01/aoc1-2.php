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

$file=file_get_contents('input1.txt');
$numbers=explode ("\n",$file);

sort($numbers);

foreach ($numbers as $i=> $a) {
    //print("DDD a=$a\n");
    for ($j=$i+1;$j<count($numbers);$j++) {
        $b=$numbers[$j];
        //print("DDD     b=$b\n");
        if ($a+$b>2020) {
            break;
        }
        for ($k=$j+1;$k<count($numbers);$k++) {
            $c=$numbers[$k];
            if ($a+$b+$c==2020) {
                print "$a $b $c\n";
                $sum=$a * $b * $c;
                print "answer $sum \n";
                exit();
            }
            if ($a+$b+$c>2020) {
                break;
            }
        }
    }
}
