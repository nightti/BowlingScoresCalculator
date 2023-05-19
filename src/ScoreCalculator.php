<?php

namespace Bowling;

class ScoreCalculator
{
    private static bool $strikeBonus = false;
    private static bool $spareBonus = false;
    private static bool $firstRoll = true;
    private static int $previousRoll = 0;
    private static int $points = 0;
    private static int $currentRound = 1;
    private static int $consecutiveStrikes = 0;

    //round 10 properties
    private static int $lastRoundRoll = 0;
    private static bool $finalRoll = false;
    private static bool $bonusRoll = false;

    public static function calculateScore(string $scores): int
    {
        self::cleanState();
        $scores = explode(',', $scores);

        foreach ($scores as $rollInput) {
            $roll = (int)$rollInput;

            if (self::$currentRound < 10) {
                self::handleNormalRound($roll);
            } else {
                self::handleLastRound($roll);
            }
        }

        return self::$points;
    }

    private static function handleNormalRound(int $roll): void
    {
        switch ($roll) {
            //handle gutter
        case(0):
            self::$strikeBonus = false;
            self::$spareBonus = false;
            self::$consecutiveStrikes = 0;
            self::$currentRound++;

            break;
            //handle strike
        case(10):
            self::$points += $roll;

            if ((self::$strikeBonus || self::$spareBonus)
                && !self::$finalRoll
            ) {
                self::$points += $roll;
            }
            self::$consecutiveStrikes++;

            if (self::$consecutiveStrikes >= 3
                && self::$currentRound <= 10
            ) {
                self::$points += $roll;
            }

            self::$currentRound++;
            self::$strikeBonus = true;
            self::$spareBonus = false;
            break;
        default:
            self::$points += $roll;

            if (!self::$firstRoll) {
                //second roll

                if (self::$strikeBonus) {
                    self::$points += $roll;
                }

                self::$spareBonus = self::$previousRoll + $roll == 10;

                //end round and reset
                self::$firstRoll = true;
                self::$strikeBonus = false;
                self::$consecutiveStrikes = 0;
                self::$currentRound++;
            } else {
                //first roll

                if ((self::$strikeBonus || self::$spareBonus)
                    && !self::$finalRoll
                ) {
                    self::$points += $roll;
                    self::$spareBonus = false;
                }
                self::$firstRoll = false;
            }

            break;
        }
        self::$previousRoll = $roll;
    }

    private static function cleanState(): void
    {
        self::$points = 0;
        self::$currentRound = 1;
        self::$strikeBonus = false;
        self::$spareBonus = false;
        self::$firstRoll = true;
        self::$previousRoll = 0;
        self::$consecutiveStrikes = 0;
        self::$lastRoundRoll = 0;
        self::$finalRoll = false;
    }

    private static function handleLastRound(int $roll): void
    {
        self::$lastRoundRoll++;

        if (self::$lastRoundRoll <= 2) {
            self::handleNormalRound($roll);
        }

        //check if bonus roll earned
        if (self::$lastRoundRoll == 1
            && self::$strikeBonus
        ) {
            self::$bonusRoll = true;
        }

        if (self::$lastRoundRoll == 3
            && (self::$bonusRoll || self::$spareBonus)
        ) {
            self::$finalRoll = true;
            self::handleNormalRound($roll);
        }
    }
}
