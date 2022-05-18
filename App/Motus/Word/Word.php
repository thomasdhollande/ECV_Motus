<?php

declare(strict_types=1);

namespace App\Motus\Word;

class Word
{
    private string $word;

    public function __construct()
    {
        if (!isset($_COOKIE['word']) || '' === $_COOKIE['word']) {
            $this->word = $this->RandomWord();
        } else {
            $this->word = $this->ExistingWord();
        }
    }

    private function RandomWord(): string
    {
        $wordSelection = new WordSelection();

        return $wordSelection->getRandomWord();
    }

    private function ExistingWord(): string
    {
        // autant le retourner direct plutôt que de stocker en mémoire
        $word = $_COOKIE['word'];

        return $word;
    }

    public function getWord()
    {
        return $this->word;
    }

    public function getWordLength(): int
    {
        return \strlen($this->word);
    }
}
