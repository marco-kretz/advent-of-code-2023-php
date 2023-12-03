<?php

namespace MarcoKretz\AdventOfCode2023\Day1;

use MarcoKretz\AdventOfCode2023\AbstractSolver;

class Solver extends AbstractSolver
{
    private const DIGIT_MAP = [
        'zero' => '0',
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
        'nine' => '9',
    ];

    public function solve(): void
    {
        print('Part 1: ' . $this->solvePart1() . PHP_EOL);
        print('Part 2: ' . $this->solvePart2() . PHP_EOL);
    }

    public function solvePart1(): int
    {
        $numbers = [];
        $file = fopen(__DIR__ . '/input.txt', 'r');
        while (!feof($file)) {
            $line = fgets($file);

            // remove all non-digit characters
            $line = preg_replace('/[^0-9]/', '', $line);

            // get first and last digit of the line
            $firstDigit = substr($line, 0, 1);
            $lastDigit = substr($line, -1);

            // add the first and last digit to the numbers array
            $numbers[] = $firstDigit . $lastDigit;
        }

        fclose($file);

        return array_sum($numbers);
    }

    public function solvePart2(): int
    {
        $numbers = [];
        $file = fopen(__DIR__ . '/input.txt', 'r');
        while (!feof($file)) {
            $line = fgets($file);

            // find all written digits in the line with their respective positions
            $matches = [];
            foreach (self::DIGIT_MAP as $word => $digit) {
                $offset = 0;
                while (($pos = strpos($line, $word, $offset)) !== false) {
                    if (!isset($matches[$word])) {
                        $matches[$word] = [];
                    }

                    $matches[$word][] = $pos;
                    $offset = $pos + 1;
                }
            }

            // replace all written digit's first character with their respective digit,
            // so overlaps are not a problem
            foreach ($matches as $word => $positions) {
                foreach ($positions as $pos) {
                    $line = substr_replace($line, self::DIGIT_MAP[$word], $pos, 1);
                }
            }

            // remove all non-digit characters
            $line = preg_replace('/[^0-9]/', '', $line);

            $firstDigit = substr($line, 0, 1);
            $lastDigit = substr($line, -1);

            $numbers[] = $firstDigit . $lastDigit;
        }

        fclose($file);

        return array_sum($numbers);
    }
}
