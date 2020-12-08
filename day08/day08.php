<?php


//tests(); exit();



$program=array();
$visit=0;

$file=file(dirname(__FILE__). '/input8.txt',FILE_IGNORE_NEW_LINES);
foreach ($file as $i => $line) {
    //acc -99
    $op=substr($line,0,3);
    $val=(int)substr($line,4);
    $program[$i]=array($op,$val,$visit);
}

//print_r($program);
list($ok,$acc) = run($program);
print "Answer 1=$acc ok=$ok\n";

$ok=false;
for($i=0;$i<count($program);$i++) {
    $op=$program[$i][0];
    $val=$program[$i][1];
    $visit=$program[$i][2];    
    if($op='jmp' && $val<0) {
        print "DDD $i jmp $val => nop\n";
        $p=$program;
        $p[$i][0]='nop';
        list($ok,$acc) = run($p);
        if ($ok) break;
    } 
}
print "Answer 2=$acc ok=$ok\n";




/*
    acc increases or decreases a single global value called the accumulator by the value given in the argument. 
        For example, acc +7 would increase the accumulator by 7. The accumulator starts at 0. 
        After an acc instruction, the instruction immediately below it is executed next.
    jmp jumps to a new instruction relative to itself. 
        The next instruction to execute is found using the argument as an offset from the jmp instruction; 
        for example, jmp +2 would skip the next instruction, jmp +1 would continue to the instruction immediately below it, and jmp -20 would cause the instruction 20 lines above to be executed next.
    nop stands for No OPeration - it does nothing. The instruction immediately below it is executed next.

*/
function run($prog) {
    $ok=true;
    $acc=0;
    $i=0;
    $n=count($prog);
    while($i<$n) {
        $op=$prog[$i][0];
        $val=$prog[$i][1];
        $visit=$prog[$i][2];
        //print("DDD $i $op $val [$visit] $acc\n");
        if ($visit==1) {
            $ok=false;
            break;
        }
        $prog[$i][2]++;

        switch($op) {
            case 'acc': $i++; $acc+=$val; 
                break;
            case 'jmp': $i+=$val; 
                break;
            case 'nop': $i++;
                break;
        }
        
        
    }
    return array($ok,$acc);
}