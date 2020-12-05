<?php

//tests();

$file=fopen(dirname(__FILE__). '/input5.txt', 'r');
if ($file===false) {
    return false;
}

$count=0;
$maxid=0;
$seats=array();
while (($line = fgets($file)) !== false) {
    $line=trim($line);
    if (strlen($line)==10) {
        $id=get_id($line);
        //print "DDD $line => $id \n";
        if ($id>$maxid) $maxid=$id;
        $seats[]=$id;
        $count++;
    }
}
fclose($file);
print "Answer 1 = $maxid ($count lines) \n";

sort($seats);

$missing=array();
$min=get_id('FFFFFFFLLL'); // id 0
$max=get_id('BBBBBBBRRR'); // id 1023
for($i=$min;$i<=$max;$i++) {
    if (array_search($i,$seats) === false) {
        $missing[]=$i;
    }
}

//print_r($missing);
foreach($missing as $id) {
    $ok1=array_search($id-1,$seats) !== false;
    if (!$ok1) continue;
    $ok2=array_search($id+1,$seats) !== false;
    if (!$ok2) continue;
    print "Answer2 Seat ID = $id\n";
}






/*
For example, consider just the first seven characters of FBFBBFFRLR:

    Start by considering the whole range, rows 0 through 127.
    F means to take the lower half, keeping rows 0 through 63.
    B means to take the upper half, keeping rows 32 through 63.
    F means to take the lower half, keeping rows 32 through 47.
    B means to take the upper half, keeping rows 40 through 47.
    B keeps rows 44 through 47.
    F keeps rows 44 through 45.
    The final F keeps the lower of the two, row 44.
*/

function get_row($seat) {
    
    $min=0;
    $max=127;

    for($i=0;$i<7;$i++) {
        $letter=$seat[$i];
        //print("DDD $i $letter $min,$max\n");
        $range=$max-$min;
        $middle=intdiv($range, 2);
        //print("DDD range $range middle $middle\n"); 
        if ($letter=='F') {
            $max=$min+$middle; 
            //print("DDD max => $max\n");  
        }
        if ($letter=='B') {
            $min=$min+$middle+1;
            //print("DDD min => $min\n");  
        }        

    }
    //print "DDD min=$min max=$max\n";
    return $min;
}
/*
For example, consider just the last 3 characters of FBFBBFFRLR:

    Start by considering the whole range, columns 0 through 7.
    R means to take the upper half, keeping columns 4 through 7.
    L means to take the lower half, keeping columns 4 through 5.
    The final R keeps the upper of the two, column 5.
*/
function get_column($seat) {
    $min=0;
    $max=7;

    for($i=7;$i<10;$i++) {
        $letter=$seat[$i];
        //print("DDD $i $letter $min,$max\n");
        $range=$max-$min;
        $middle=intdiv($range, 2);
        //print("DDD range $range middle $middle\n"); 
        if ($letter=='L') {
            $max=$min+$middle; 
            //print("DDD max => $max\n");  
        }
        if ($letter=='R') {
            $min=$min+$middle+1;
            //print("DDD min => $min\n");  
        }        
    }
    //print "DDD min=$min max=$max\n";
    return $min;
}

function get_id($seat) {
    $row=get_row($seat);
    $column=get_column($seat);
    return $row * 8 + $column;
}


/*
    FBFBBFFRLR: row 44, column 5, seat ID 357.
    BFFFBBFRRR: row 70, column 7, seat ID 567.
    FFFBBBFRRR: row 14, column 7, seat ID 119.
    BBFFBBFRLL: row 102, column 4, seat ID 820.
*/
function tests() {
    
    assert(get_row('FBFBBFFRLR')==44);
    assert(get_row('BFFFBBFRRR')==70);
    assert(get_row('FFFBBBFRRR')==14);
    assert(get_row('BBFFBBFRLL')==102);

    assert(get_column('FBFBBFFRLR')==5);
    assert(get_column('BFFFBBFRRR')==7);
    assert(get_column('FFFBBBFRRR')==7);
    assert(get_column('BBFFBBFRLL')==4);    

    assert(get_id('FBFBBFFRLR')==357);
    assert(get_id('BFFFBBFRRR')==567);
    assert(get_id('FFFBBBFRRR')==119);
    assert(get_id('BBFFBBFRLL')==820);
}

/*
FFFFFFFLLL row 0   column 0 id 0
FFFFFFFRRR row 0   column 7 id 7
BBBBBBBLLL row 127 column 0 id 1016
BBBBBBBRRR row 127 column 7 id 1023
*/
function info1() {

    $seats=array(
        'FFFFFFFLLL',
        'FFFFFFFRRR',
        'BBBBBBBLLL',
        'BBBBBBBRRR'
    );
    foreach($seats as $seat) {
        $id=get_id($seat);
        $row=get_row($seat);
        $column=get_column($seat);
        print "$seat row $row column $column id $id\n";
    }
}