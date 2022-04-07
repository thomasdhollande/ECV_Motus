<?php

declare(strict_types=1);

namespace App\Motus\Word;

use App\Motus\Word\WordSelection;

class Word
{
    private string $word;

    public function __construct()
    {
        if (!isset($_COOKIE['word']) || $_COOKIE['word'] === '') {
            $this->word = $this->RandomWord();
        } else {
            $this->word = $this->ExistingWord();
        }
    }

    private function RandomWord(): string
    {
        $wordSelection = new WordSelection();
        $word = $wordSelection->getRandomWord();
        return $word;
    }

    private function ExistingWord(): string
    {
        $word = $_COOKIE['word'];
        return $word;
    }

    public function getWord() {
        return $this->word;
    }

    public function getWordLength(): int {
        return strlen($this->word);
    }
}
