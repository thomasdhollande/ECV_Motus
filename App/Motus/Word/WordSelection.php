<?php

declare(strict_types=1);

namespace App\Motus\Word;

use App\Motus\Word\WordLoading;

class WordSelection
{
    public function getRandomWord()
    {
        $WordLoading = new WordLoading();
        $words = $WordLoading->loadFile();
        $arrayWords = explode(PHP_EOL, $words);
        $randomWord = $arrayWords[array_rand($arrayWords)];
        return $randomWord;
    }
}
