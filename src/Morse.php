<?php

class Morse
{
    private $morse = [
        '·-'     => 'a',
        '-···'   => 'b',
        '-·-·'   => 'c',
        '-··'    => 'd',
        '·'      => 'e',
        '··-·'   => 'f',
        '--·'    => 'g',
        '····'   => 'h',
        '··'     => 'i',
        '·---'   => 'j',
        '-·-'    => 'k',
        '·-··'   => 'l',
        '--'     => 'm',
        '-·'     => 'n',
        '---'    => 'o',
        '·--·'   => 'p',
        '--·-'   => 'q',
        '·-·'    => 'r',
        '···'    => 's',
        '-'      => 't',
        '··-'    => 'u',
        '···-'   => 'v',
        '·--'    => 'w',
        '-··-'   => 'x',
        '-·--'   => 'y',
        '--··'   => 'z',
        '-----'  => '0',
        '·----'  => '1',
        '··---'  => '2',
        '···--'  => '3',
        '····-'  => '4',
        '·····'  => '5',
        '-····'  => '6',
        '--···'  => '7',
        '---··'  => '8',
        '----·'  => '9',
        '·-·-·-' => '.',
        '--··--' => ',',
        '··--··' => '?',
        '---···' => ':',
        '-··-·'  => '/',
        '·-··-·' => '"',
        '·----·' => '\'',
        '-·-·-·' => ';',
        '-·-·--' => '!',
        '·--·-·' => '@'
    ];

    private $morseSpecial = [
        '··-·-'     => 'signing-off',
        '········'  => 'signing-error',
        '···---···' => 'sos'
    ];

    private $morseFlipped;
    private $morseFlippedSpecial;

    const LOWERCASE = false;
    const UPPERCASE = true;

    private $string;
    private $case = self::UPPERCASE;

    public function __construct(string $string)
    {
        $this->string = (mb_strtolower(trim($string)));
        $this->morseFlipped = array_flip($this->morse);
        $this->morseFlippedSpecial = array_flip($this->morseSpecial);
    }

    public function setCase(bool $case = self::UPPERCASE)
    {
        if ($case) {
            $this->case = self::UPPERCASE;
        } else {
            $this->case = self::LOWERCASE;
        }
    }

    public function decode()
    {
        $result = '';

        // В описании задания использованы точки по середине строки, потому приведем схожие символы к эталонным
        $this->string = str_replace(".", "·", $this->string);
        $this->string = str_replace("_", "-", $this->string);
        $this->string = str_replace("—", "-", $this->string);

        $words = explode('   ', $this->string);
        // Очистим лишние пробелы в словах (могут появиться, если пользователь ошибся с их количеством)
        $words = array_map('trim', $words);
        foreach ($words as $word) {
            if (array_key_exists($word, $this->morseSpecial)) {
                $result .= $this->morseSpecial[$word] . ' ';
                continue;
            }
            $word = preg_replace('|([\s]{2,})|', ' ', $word);

            $letters = explode(' ', $word);
            foreach ($letters as $letter) {
                if (isset($this->morse[$letter])) {
                    $result .= $this->morse[$letter];
                } else {
                    $result .= $letter;
                }
            }
            $result .= ' ';
        }

        if ($this->case) {
            $result = mb_strtoupper($result);
        } else {
            $result = mb_strtolower($result);
        }

        return trim($result);
    }

    public function encode()
    {
        $result = '';

        $this->string = preg_replace('|([\s]{2,})|', ' ', $this->string);
        $words = explode(' ', $this->string);

        $words = array_map('trim', $words);
        foreach ($words as $word) {
            if (array_key_exists($word, $this->morseFlippedSpecial)) {
                $result .= $this->morseFlippedSpecial[$word] . '   ';
                continue;
            }

            $letters = str_split($word);
            foreach ($letters as $letter) {
                if (isset($this->morseFlipped[$letter])) {
                    $result .= $this->morseFlipped[$letter];
                } else {
                    $result .= $letter;
                }
                $result .= ' ';
            }
            $result .= '   ';
        }

        if ($this->case) {
            $result = mb_strtoupper($result);
        } else {
            $result = mb_strtolower($result);
        }

        return trim($result);
    }
}