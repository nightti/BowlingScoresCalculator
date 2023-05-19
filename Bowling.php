<?php

declare(strict_types=1);

// load the composer autoloader
require 'vendor/autoload.php';

/* my rules:
* 1 - every input is a single roll, not rounds e.g. 5,5 and not 5/5
* 2 - script cannot look into the future (know what the next roll is )
* 3 - script can correctly show partial scores (10,10,10 = 60) (10,10,10,10 = 90)
* 4 - assumes correct input
*/

use Bowling\ScoreCalculator;

echo "Bitte geben Sie Ihre Würfe als kommagetrennte Liste ein:\n";
echo "z.b.: 10,10,10,10,10,10,10,10,10,10,10,10\n";
echo "10 = strike\n";
echo "9,1/7,3 etc.. = spare\n";
echo "0 = gutter\n";


$input = readline();

try {
    echo ScoreCalculator::calculateScore($input);
} catch (Error $error) {
    echo $error->getMessage();
}
