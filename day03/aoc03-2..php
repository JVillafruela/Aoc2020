<?php

$forest=array();
$width=0;
$height=0;

$ok=read_playground('input3.txt', $forest, $width, $height);
if (!$ok) {
    die("error reading input file");
}

print("width=$width height=$height \n");
//print_playground($forest,$width,$height);

$run=array(
    array( 1,  1),
    array( 3,  1),
    array( 5,  1),
    array( 7,  1),
    array( 1,  2)
);

$answer=1;
foreach ($run as $i => $r) {
    $count=walk($forest, $width, $height, $r[0], $r[1]);
    print("run $i count=$count \n");
    $answer *= $count;
}
print("Answer = $answer \n");

function walk($forest, $width, $height, $dx, $dy)
{
    $x=0;
    $y=0;
    $count=0;
    while ($y<$height) {
        //print("DDD $x $y "); print($forest[$x][$y]==1 ? '#' : '.' ); print("\n");
        if ($forest[$y][$x]==1) {
            $count++;
        }
        $x+=$dx;
        if ($x>$width-1) {
            $x-=$width;
        }
        $y+=$dy;
    }

    return $count;
}

function read_playground($filename, &$forest, &$width, &$height)
{
    $file=fopen(dirname(__FILE__). '/' . $filename, 'r');
    if ($file===false) {
        return false;
    }
    $i=0;
    while (($line = fgets($file)) !== false) {
        $line=trim($line);
        //print("DDD line $i $line \n");
        // ..##.......
        if ($line=='') {
            continue;
        }
        
        $width=strlen($line);
        for ($j=0;$j<$width;$j++) {
            switch ($line[$j]) {
                case '.':
                    $forest[$i][$j]=0;
                    break;
                case '#':
                    $forest[$i][$j]=1;
                    break;
            }
        }
        $i++;
    }
    $height=$i;
    fclose($file);
    return true;
}


function print_playground($forest, $width, $height)
{
    for ($i=0;$i<$height;$i++) {
        for ($j=0;$j<$width;$j++) {
            print($forest[$i][$j]==1 ? '#' : '.');
        }
        print("\n");
    }
}
