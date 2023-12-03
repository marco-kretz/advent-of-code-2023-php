<?php

namespace MarcoKretz\AdventOfCode2023;

/**
 * Simple abstract solver class to provide a common interface for all solvers.
 */
abstract class AbstractSolver
{
    abstract public function solve(): void;
}
