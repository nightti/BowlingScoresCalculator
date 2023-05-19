<?php

declare(strict_types=1);

use Bowling\ScoreCalculator;
use PHPUnit\Framework\TestCase;

class ScoreCalculatorTest extends TestCase
{
    /**
     * @dataProvider provideRollsData
     */
    public function testCalculations($expectedResult, $input): void
    {
        $actual = ScoreCalculator::calculateScore($input);

        $this->assertSame($expectedResult, $actual);
    }

    public static function provideRollsData(): array
    {

        return [
            [
                'score' => 300,
                'sheet' => '10,10,10,10,10,10,10,10,10,10,10,10',
            ],
            [
                'score' => 295,
                'sheet' => '10,10,10,10,10,10,10,10,10,10,10,5',
            ],
            [
                'score' => 270,
                'sheet' => '10,10,10,10,10,10,10,10,10,10,0,0',
            ],
            [
                'score' => 70,
                'sheet' => '4,3,4,3,4,3,4,3,4,3,4,3,4,3,4,3,4,3,4,3',
            ],
            [
                'score' => 181,
                'sheet' => '9,1,9,1,9,1,9,1,9,1,9,1,9,1,9,1,9,1,9,1,0'
            ],
            [
                'score' => 193,
                'sheet' => '9,1,10,9,1,10,9,1,10,9,1,10,9,1,10,0,3'
            ],
            [
                'score' => 87,
                'sheet' => '5,0,3,4,5,2,9,0,3,3,6,3,7,3,9,0,3,4,9,0'
            ],
            [
                'score' => 191,
                'sheet' => '9,1,9,1,9,1,9,1,9,1,9,1,9,1,9,1,9,1,9,1,10'
            ],
            [
                'score' => 200,
                'sheet' => '10,9,1,10,9,1,10,9,1,10,9,1,10,9,1,10,9,1,10,9,1,10,9,1,10,9,1,10,9,1'
            ],
            [
                'score' => 0,
                'sheet' => '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'
            ],
            [
                'score' => 300,
                'sheet' => '10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10',
            ],
        ];
    }
}
