<?php

$string = "561;2,3,4";
$obj = explode('|', $string);

$t = [];

foreach ($obj as $key => $value) {

    $v = explode(';', $value);

    $t[] = [
        'category' => $v[0],
        'properties' => explode(',', $v[1]),
    ];
}

var_dump($t);