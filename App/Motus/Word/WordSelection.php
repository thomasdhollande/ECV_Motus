<?php

declare(strict_types=1);

namespace App\Motus\Word;

class WordSelection
{
    public function getRandomWord()
    {
        $WordLoading = new WordLoading();
        $words = $WordLoading->loadFile();
        $arrayWords = explode(\PHP_EOL, $words);

        return $arrayWords[array_rand($arrayWords)];
    }
}
