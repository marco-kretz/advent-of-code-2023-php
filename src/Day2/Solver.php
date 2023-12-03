<?php

namespace MarcoKretz\AdventOfCode2023\Day2;

use MarcoKretz\AdventOfCode2023\AbstractSolver;

class Solver extends AbstractSolver
{
    public function solve(): void
    {
        print('Part 1: ' . $this->solvePart1() . PHP_EOL);
        print('Part 2: ' . $this->solvePart2() . PHP_EOL);
    }

    public function solvePart1(): int
    {
        $games = $this->readInput();

        // Filter out impossible games
        $possibleGames = array_filter($games, static function (array $game): bool {
            return $game['max']['red'] <= 12
                && $game['max']['green'] <= 13
                && $game['max']['blue'] <= 14;
        });

        // Sum up the ids of the possible games
        return array_sum(array_keys($possibleGames));
    }

    public function solvePart2(): int
    {
        $games = $this->readInput();

        // Sum up the powers of all games
        return array_reduce($games, static function (int $carry, array $game): int {
            $carry += $game['power'];

            return $carry;
        }, 0);
    }

    private function readInput(): array
    {
        $file = fopen(__DIR__ . '/input.txt', 'r');
        $input = [];

        while (!feof($file)) {
            $line = fgets($file);

            $gameInfo = explode(':', $line);
            $gameId = (int) str_replace('Game ', '', $gameInfo[0]);
            $input[$gameId] = [
                'max' => [
                    'red' => 0,
                    'green' => 0,
                    'blue' => 0,
                ],
            ];

            $draws = explode(';', $gameInfo[1]);
            foreach ($draws as $index => $draw) {
                foreach (explode(',', $draw) as $drawInfo) {
                    $drawInfo = trim($drawInfo);
                    [$count, $color] = explode(' ', $drawInfo);
                    $input[$gameId][$index][$color] = (int) $count;

                    // Track max number of cubes of each color
                    if ($input[$gameId][$index][$color] > $input[$gameId]['max'][$color]) {
                        $input[$gameId]['max'][$color] = $input[$gameId][$index][$color];
                    }
                }
            }

            // Calculate power of the game
            $input[$gameId]['power'] = $input[$gameId]['max']['red'] * $input[$gameId]['max']['green'] * $input[$gameId]['max']['blue'];
        }

        fclose($file);

        return $input;
    }
}
