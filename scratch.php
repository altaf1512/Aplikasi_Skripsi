<?php
$rules = [
    1 => ['B'=>0.2, 'T'=>0.4, 'J'=>0.8],
    2 => ['B'=>0.8, 'T'=>0.6, 'J'=>0.2],
    3 => ['B'=>0.9, 'T'=>0.5, 'J'=>0.1],
    4 => ['B'=>0.8, 'T'=>0.7, 'J'=>0.3],
    5 => ['B'=>0.5, 'T'=>0.4, 'J'=>0.8],
    6 => ['B'=>0.9, 'T'=>0.6, 'J'=>0.2],
    7 => ['B'=>1.0, 'T'=>0.8, 'J'=>0.1],
    8 => ['B'=>0.9, 'T'=>0.8, 'J'=>0.2],
    9 => ['B'=>0.8, 'T'=>0.5, 'J'=>0.2],
    10=> ['B'=>0.1, 'T'=>0.2, 'J'=>0.9],
    11=> ['B'=>0.2, 'T'=>0.4, 'J'=>0.8],
    12=> ['B'=>0.9, 'T'=>0.8, 'J'=>0.1],
];

function combine($cfOld, $cfRule) {
    if ($cfOld >= 0 && $cfRule >= 0) {
        return $cfOld + $cfRule * (1 - $cfOld);
    } elseif ($cfOld < 0 && $cfRule < 0) {
        return $cfOld + $cfRule * (1 + $cfOld);
    } else {
        $denominator = 1 - min(abs($cfOld), abs($cfRule));
        return $denominator > 0 ? ($cfOld + $cfRule) / $denominator : 0;
    }
}

$options = [-1, -0.4, 0.2, 0.6, 1];

for ($i=0; $i<100000; $i++) {
    $ans = [];
    $cf = ['B'=>0, 'T'=>0, 'J'=>0];
    $first = ['B'=>true, 'T'=>true, 'J'=>true];
    
    foreach($rules as $q=>$r) {
        $user = $options[array_rand($options)];
        $ans[$q] = $user;
        foreach(['B', 'T', 'J'] as $h) {
            $cfR = $user * $r[$h];
            if ($first[$h]) {
                $cf[$h] = $cfR;
                $first[$h] = false;
            } else {
                $cf[$h] = combine($cf[$h], $cfR);
            }
        }
    }
    
    // We want Tahan > Beli AND Tahan > Jual AND Tahan is positive (e.g. > 0.5)
    if ($cf['T'] > $cf['B'] && $cf['T'] > $cf['J'] && $cf['T'] > 0.5) {
        echo "Found Tahan! \nAnswers: " . json_encode($ans) . "\nResults: " . json_encode($cf) . "\n";
        break;
    }
}
