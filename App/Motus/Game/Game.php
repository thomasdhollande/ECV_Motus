<?php

declare(strict_types=1);

namespace App\Motus\Game;

class Game
{
    private int $maxTurns = 6;

    public function getMaxTurns(): int
    {
        return $this->maxTurns;
    }
}
