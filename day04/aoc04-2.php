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
        //print "DDD1 $passport => $ok \n";
        $count += $ok;
        $passport='';

        continue;
    }
    $passport .=  $line . ' ' ;
}
fclose($file);
$ok = check_passport($passport,$fields);
//print "DDD2 $passport => $ok \n";
$count += $ok;

print "Answer $count \n";

// return 1 if passport is valid, 0 else
function check_passport($passport,array $fields) {
    $passport=trim($passport);
    if ($passport=='') return 0;
    foreach ($fields as $field) {
        $str = $field . ':';
        if (strpos($passport,$str)===false) return 0;
    }

    $chunks=explode(" ",$passport);
    foreach ($chunks as $chunk) {
        list($field,$value)=explode(":",$chunk);
        //print("DDD $chunk $field,$value\n");
        if (!check_field($field,$value)) return 0;
    }
    return 1;
}

function check_field($field,$value) {
    switch($field) {
        case 'byr': return check_year($value,1920,2002);
        case 'iyr': return check_year($value,2010,2020);
        case 'eyr': return check_year($value,2020,2030);
        case 'hgt': return check_hgt($value);
        case 'hcl': return check_hcl($value);
        case 'ecl': return check_ecl($value);
        case 'pid': return check_pid($value);
    }
    return true;
}

function check_number($value,$min,$max) {
    if (!is_numeric($value)) return false;
    $ok= $min <= $value && $value <= $max;
    //print("DDD check_number($value,$min,$max) => $ok\n");
    return $min <= $value && $value <= $max;
}

function check_year($value,$min,$max) {
    if (strlen($value)!=4) return false;
    return check_number($value,$min,$max);
}

/*
hgt (Height) - a number followed by either cm or in:
    If cm, the number must be at least 150 and at most 193.
    If in, the number must be at least 59 and at most 76.
*/
function check_hgt($value) {
    if(preg_match('/(\d+)(cm|in)/', $value, $matches, PREG_OFFSET_CAPTURE)!==1)
        return false;

    if ($matches[2][0]=='cm') {
        $min=150;
        $max=193;    
    } else {
        $min=59;
        $max=76;        
    }
    return check_number($matches[1][0],$min,$max);
}

// hcl (Hair Color) - a # followed by exactly six characters 0-9 or a-f.
function check_hcl($value) {
    $ok=preg_match('/#([0-9]|[a-f]){6}/',$value);
    return $ok==1 ? true : false;
}
//ecl (Eye Color) - exactly one of: amb blu brn gry grn hzl oth.
function check_ecl($value) {
    $ok=preg_match('/amb|blu|brn|gry|grn|hzl|oth/',$value);    
    return $ok==1 ? true : false;
}

// pid (Passport ID) - a nine-digit number, including leading zeroes.
function check_pid($value) {
    $ok=strlen($value)==9 & preg_match('/([0-9]){9}/',$value);
    return $ok==1 ? true : false;
}

/*


*/
function tests() {
    $tests='
    iyr valid   2015
    iyr invalid 2003
    iyr invalid 20
    iyr invalid year

    byr valid   2002
    byr invalid 2003
    byr invalid 20
    byr invalid year

    eyr valid   2025
    eyr invalid 2001
    eyr invalid 20
    eyr invalid year

    hgt valid   60in
    hgt valid   190cm
    hgt invalid 190in
    hgt invalid 190

    hcl valid   #123abc
    hcl invalid #123abz
    hcl invalid 123abc

    ecl valid   brn
    ecl invalid wat

    pid valid   000000001
    pid invalid 0123456789
    pid invalid onetwo';

    foreach (explode("\n",$tests) as $test) {
        $test=trim($test);
        if ($test=='') continue;
        list($field,$ok,$value)= preg_split("/[\s]+/", $test);
        //print "DDD $field,$ok,$value \n";
        $result=$ok == 'valid' ? '1' :'0';
        $call="check_field('$field','$value') == $result";
        //print "DDD $test $call\n";
        assert($call,$test);
    }

    
}