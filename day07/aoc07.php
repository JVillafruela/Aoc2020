<?php

//tests(); exit();

$count=0;
$outer_bags=array();


$file=fopen(dirname(__FILE__). '/input7.txt', 'r');
if ($file===false) {
    return false;
}

while (($line = fgets($file)) !== false) {
    $line=trim($line);
    if ($line=='') continue;

    $line=str_replace('bags','bag',$line);
    $ok=main_bag($line,$main_bag,$other);
    //print("DDD $line ok=$ok\n");
    $bags=next_bags($other);
    if($bags==false || !is_array($bags)) continue;
    $count++;

    foreach($bags as $bag) {
        $name=$bag['name'];
        $outer_bags[$main_bag][]=$name;
    }


}
fclose($file);

//print_r($outer_bags);

$bags=enclosing_bags($outer_bags,'shiny gold'); 
//print_r($bags);
$answer=count($bags);
print "Answer ($count lines) $answer\n"; 
//187 too high 185 ok

function enclosing_bags($outer_bags,$name) {
    //print("DDD enclosing_bags($name)\n");
    $result=array();
    $bags1=array();
    $bags2=array();
    foreach ($outer_bags as $outer_name => $bags) {
        if(array_search($name,$bags) !== false) {
            //print("DDD   in $outer_name \n");
            $bags1[]=$outer_name;    
        }
    }
    foreach ($bags1 as $bagname) {
        $bags=enclosing_bags($outer_bags, $bagname);
        foreach ($bags as $bag) {
            if(array_search($bag,$bags2)===false) {
                $bags2[]=$bag;
            }
        }
    }
    assert(is_array($bags1));
    assert(is_array($bags2));
    $result = array_unique(array_merge($bags1,$bags2));

    //print("DDD '$name' bags1  ") . implode(',',$bags1) . "\n";
    //print("DDD '$name' bags2  ") . implode(',',$bags2) . "\n";
    
    return $result;
}


//light red bag contain 1 bright white bag, 2 muted yellow bag.
//dotted black bag contain no other bags.
function main_bag($line,&$bag,&$other_bags) {
    $pattern=' bag contain';
    $i=strpos($line,$pattern);
    if ($i==false) {
        return false;
    }
    $bag=substr($line,0,$i);
    $other_bags=substr($line,$i+strlen($pattern)+1);
    if($other_bags=='no other bags.' ) {
        $other_bags='';
    }
    return true;
}

//1 bright white bag, 2 muted yellow bag.
//1 shiny gold bag.
function next_bags($line) {
    if(strlen($line)==0 || !is_numeric($line[0])) return false;

    $n=preg_match_all('/(\d+) (([\w ]+) bag)/',$line,$matches,PREG_SET_ORDER);
    if($n===false) return false;
    /*
    [0] => Array
        (
            [0] => 1 bright white bag
            [1] => 1
            [2] => bright white bag
            [3] => bright white
        )
    */
    $bags=array();
    for($i=0;$i<$n;$i++) {
        $bags_count=$matches[$i][1];
        $bag_name=$matches[$i][3];
        $bags[$i]['count']=$bags_count;
        $bags[$i]['name']=$bag_name;
    }
    return $bags;
}


function tests() {
    $line='light red bags contain 1 bright white bag, 2 muted yellow bags.';
    $line=str_replace('bags','bag',$line);

    $ok=main_bag($line,$bag,$other);
    assert($ok);
    assert($bag=='light red');
    assert($other=='1 bright white bag, 2 muted yellow bag.');

    $bags=next_bags($other);
    assert($bags !== false && is_array($bags));
    assert(count($bags)==2);
    assert($bags[0]['name']=='bright white');
    assert($bags[0]['count']==1);
    assert($bags[1]['name']=='muted yellow');
    assert($bags[1]['count']==2);  
    
    
    $line='dotted black bag contain no other bags.';
    $ok=main_bag($line,$bag,$other);
    assert($ok);
    assert($bag=='dotted black');
    assert($other=='');   


}