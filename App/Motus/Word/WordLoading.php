<?php

declare(strict_types=1);

namespace App\Motus\Word;

class WordLoading
{
    private const FILE_PATH = __DIR__.'/../Dictionnary/Dictionnary.txt';
    private string $words;

    public function loadFile(): string
    {
        if (empty($this->words)) {
            $this->words = file_get_contents(self::FILE_PATH, true);
        }

        return $this->words;
    }
}
