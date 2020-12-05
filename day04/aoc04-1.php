<?php

//mandatory fields only
$fields=array(
    'byr', //Birth Year)
    'iyr', //Issue Year)
    'eyr', //Expiration Year)
    'hgt', //Height)
    'hcl', //Hair Color)
    'ecl', //Eye Color)
    'pid' //Passport ID)
    //'cid', //Country ID)
 );


$file=fopen(dirname(__FILE__). '/input4.txt', 'r');
if ($file===false) {
    return false;
}
$count=0;
$passport='';

while (($line = fgets($file)) !== false) {
    $line=trim($line);
    //print("DDD line $i $line \n");
    // ..##.......
    if ($line=='') {
        $ok = check_passport($passport,$fields);
        print "DDD1 $passport => $ok \n";
        $count += $ok;
        $passport='';

        continue;
    }
    $passport .=  $line . ' ' ;
}
fclose($file);
$ok = check_passport($passport,$fields);
print "DDD2 $passport => $ok \n";
$count += $ok;

print "Answer $count \n";

// return 1 if passport is valid, 0 else
function check_passport($passport,array $fields) {
    if (trim($passport)=='') return 0;
    foreach ($fields as $field) {
        $str = $field . ':';
        if (strpos($passport,$str)===false) return 0;
    }
    return 1;
}