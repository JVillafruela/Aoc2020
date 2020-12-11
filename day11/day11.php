<?php

define('FREE','L');
define('OCCUPIED','#');
define('FLOOR','.');

//tests();

$area=read_str('input11.txt');
$a=fill($area);
$n=count_seats_area($a,OCCUPIED);
print("Answer $n \n");

//$area=read_str('test-input.txt');


function tests(){
    $area=read_str('test-input.txt');
    $final=read_str('test-result.txt');

    assert(get_seat($area,10,0)=='');
    assert(get_seat($area,0,10)=='');    
    assert(get_seat($area,0,-1)=='');  
    assert(get_seat($area,-1,0)=='');       
    assert(get_seat($area,0,0)==FREE);
    assert(get_seat($area,0,1)==FLOOR);    

    assert(same_area($area,$area));
    assert(!same_area($area,$final));   

    $seats=adjacent_seats($area,0,0);
    assert(count_seats($seats,OCCUPIED)==0);
    assert(count_seats($seats,FLOOR)==1);

    $seats=adjacent_seats($area,2,2);
    assert(count_seats($seats,OCCUPIED)==0);
    assert(count_seats($seats,FREE)==6);
    assert(count_seats($seats,FLOOR)==2);   

   
    $a=fill($area);
    //print_seats($a);
    assert(same_area($a,$final));

    assert(count_seats_area($final,OCCUPIED)==37);
}

// $i line, $j column
function get_seat(array $area,$i,$j) {
    if($i<0 || $j<0) return '';
    if($i>=count($area)) return '';
    if($j>=strlen($area[$i])) return '';
    //print "DDD ". $area[$i][$j]  ."\n"; 
    return $area[$i][$j];
}

function same_area(array $area1,array $area2) {
    if(count($area1)!=count($area2)) return false;
    for($i=0;$i<count($area1);$i++) {
        //print "DDD $area1[$i],$area2[$i] \n";
        $ok=strcmp($area1[$i],$area2[$i])==0;
        if(!$ok) {
            //print "DDD same_area diff line $i \n";
            //print "DDD           $area1[$i] \n";
            //print "DDD           $area2[$i] \n"; 
            break;           
        } 
    }    
    return $ok;
}

function adjacent_seats(array $area, $i, $j) {
    $buf=get_seat($area,$i-1,$j-1) .
         get_seat($area,$i-1,$j) . 
         get_seat($area,$i-1,$j+1) . 
         get_seat($area,$i,$j-1) .
         get_seat($area,$i,$j+1) .      
         get_seat($area,$i+1,$j-1) .
         get_seat($area,$i+1,$j) . 
         get_seat($area,$i+1,$j+1); 
    return str_split($buf);           
}

function count_seats(array $seats,$type) {
    $count=array_count_values($seats); 
    if (!array_key_exists($type,$count)) return 0;
    return $count[$type];  
}

function count_seats_area(array $area,$type) {
    $n=0;
    for ($i=0;$i<count($area);$i++) {
        $seats=str_split($area[$i]);
        $n+=count_seats($seats,$type);
    }
    return $n;  
}

function fill($area) {
    $a=$area;
    $n=0;
    do {
        $n++;
        print "DDD round $n\n";
        $b=$a;
        for ($i=0;$i<count($a);$i++) {
            $line='';
            for($j=0;$j<strlen($a[$i]);$j++) {
                $seats=adjacent_seats($b,$i,$j);
                switch($b[$i][$j]) {
                    case FREE:
                        if(count_seats($seats,OCCUPIED)==0) {
                           $line .= OCCUPIED;
                        } else {
                           $line .= $b[$i][$j];
                        }
                    break;
                    case OCCUPIED:
                        if(count_seats($seats,OCCUPIED)>=4) {
                            $line .= FREE;
                         } else {
                            $line .= $b[$i][$j]; 
                         }
                     break;
                    default:
                    $line .= $b[$i][$j];
                }            
            }
            //print("DDD $i $a[$i] => $line \n");
            $a[$i]=$line;
        }

        //if($n == 100 ) die("DDD fill loop");
    } while (!same_area($a,$b));

    return $a;
}




function print_seats($area) {
    for ($i=0;$i<count($area);$i++) {
        print $area[$i] . "\n";
    } 
}


function read_str($name)
{
    $strings=array();

    $file=file(dirname(__FILE__) .'/'. $name, FILE_IGNORE_NEW_LINES);
    if ($file===false) return false;

    foreach ($file as $i => $line) {
        $strings[$i]=$line;
    }

    return $strings;
}
