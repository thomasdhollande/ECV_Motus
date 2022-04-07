<?php

declare(strict_types=1);

namespace App\Motus\Letters;

use App\Motus\Player\Player;
use App\Motus\Word\Word;

class Letters
{
    public function getLetterState($index, $letter)
    {
        $objWord = new Word();
        $word = $objWord->getWord();
        $word = str_split($word);
        if (in_array($letter, $word)) {
            if ($word[$index] === $letter) {
                return 'good';
            }
            return 'misplaced';
        }
        return 'notGood';
    }

    public function getLetter($letter, $state)
    {
        switch ($state) {
            case 'good':
                return "<div class='case_good'><span>$letter</span></div>";
                break;
            case 'misplaced':
                return "<div class='case_misplaced'><span>$letter</span></div>";
                break;
            case 'notGood':
                return "<div class='case_notGood'><span>$letter</span></div>";
                break;
        }
    }

    public function gameIsWin($array_state): bool {
        if (is_array($array_state) && !empty($array_state)) {
            foreach ($array_state as $state) {
                if ($state !== 'good') {
                    return false;
                }
            }
            return true;
        }
    }
}
