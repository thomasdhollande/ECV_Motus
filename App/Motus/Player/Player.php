<?php

declare(strict_types=1);

namespace App\Motus\Player;

use App\Motus\Game\Game;
use App\Motus\Letters\Letters;
use App\Motus\Word\Word;

// dommage le mélange logique/render
class Player
{
    private string $playersLetters;

    public function __construct()
    {
        if (isset($_GET['playersletters'])) {
            $word = new Word();
            $this->playersLetters = substr($_GET['playersletters'], 0, $word->getWordLength());
            unset($word);
        } else {
            $this->playersLetters = '';
        }
    }

    public function getPlayersLetters(): string
    {
        return $this->playersLetters;
    }

    public function getPlayersWord(): string
    {
        $playersWord = $this->playersLetters;

        $word = new Word();
        $emptyLetter = $word->getWordLength() - $this->getPlayersLettersLength();
        for ($i = 0; $i < $emptyLetter; ++$i) {
            $playersWord .= ' _';
        }

        return $playersWord;
    }

    public function getPlayersLettersLength(): int
    {
        return \strlen($this->playersLetters);
    }

    public function getPlayersElements(): string
    {
        $return = '';

        $str_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $arr_alphabet = str_split($str_alphabet);

        $arr_players_word = str_split($this->getPlayersWord());

        $return .= '<div class="players_elements container">';

        $return .= '    <div class="players_word_container">';
        foreach ($arr_players_word as $letter) {
            $return .= "    <span>$letter</span>";
        }
        $return .= '    </div>';

        if (!strpos($this->getPlayersWord(), '_')) {
            $return .= "<form action='/' method='POST'>";
            $return .= "    <input type='hidden' name='players_word' value='".$this->getPlayersWord()."'/>";
            $return .= "    <input type='submit' value='Valider'/ class='button'>";
            $return .= '</form>';
        }

        $return .= '    <div class="alphabet_container">';
        foreach ($arr_alphabet as $letter) {
            if (!isset($_GET) || empty($_GET)) {
                $return .= "    <a href='".SITE_URL."?playersletters=$letter'>$letter</a>";
            } elseif (isset($_GET['playersletters'])) {
                $return .= "    <a href='".SITE_URL.$letter."'>$letter</a>";
            } else {
                $return .= "    <a href='".SITE_URL."&playersletters=$letter'>$letter</a>";
            }
        }
        $return .= '    </div>';

        $return .= '</div>';

        return $return;
    }

    public function getGrid($word): string
    {
        $game = new Game();
        $max_turns = $game->getMaxTurns();

        $letters = new Letters();

        $return = '<div class="grid_container">';
        for ($i = 1; $i <= $max_turns; ++$i) {
            $letters_states = [];

            $return .= '<div class="grid">';
            $try = trim($_COOKIE["try$i"]);
            // yark inverse tes conditions pour éviter des inclusions
            // regarde c'est plus net comme ça
            if (!isset($_COOKIE["try$i"]) || !isset($try) || '' === $try) {
                $return .= '</div>';
                continue;
            }

            $try = str_split($try);
            if (!\is_array($try) || empty($try)) {
                $return .= '</div>';
                continue;
            }

            foreach ($try as $index => $letter) {
                $letter_state = $letters->getLetterState($index, $letter);
                $letters_states[] = $letter_state;
                $return .= $letters->getLetter($letter, $letter_state);
            }

            if ($letters->gameIsWin($letters_states)) {
                setcookie('gameWin', 'yes');
                $_COOKIE['gameWin'] = 'yes';
            }
            // ça devrait pas être un else, sinon faut rejouer une lettre pour déclencher la loose
            // ensuite il faudrait que la logique de check soit séparé de l'affichage pour s'adapter avant le prochain affichage
            // genre dans WordIsproposed en fait
            if (!$letters->gameIsWin($letters_states) && $_SESSION['turns'] >= $max_turns) {
                setcookie('gameLoose', 'yes');
                $_COOKIE['gameLoose'] = 'yes';
            }

            $return .= '</div>';
        }
        $return .= '</div>';

        unset($game);

        return $return;
    }

    // public function getPlayersTry()
    // {
    //     $game = new Game();
    //     $max_turns = $game->getMaxTurns();

    // }
}
