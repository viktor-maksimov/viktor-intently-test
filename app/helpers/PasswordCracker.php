<?php

namespace App\Helpers;

class PasswordCracker {
    public $hardPasswords = [];
    private $dictionaryWords = [];
    private $salt = 'ThisIs-A-Salt123';

    public function __construct(int $length = 6) {
        $this->dictionaryWords = $this->getDictionaryWords();
        $this->hardPasswords = $this->generateHardPasswords('', $length);
    }

    private function getDictionaryWords() {
        $filePath = __DIR__ . '/words_length_max_6.txt';

        if (!file_exists($filePath)) {
            die("File not found.");
        }

        // Read the dictionary words into an array, one line per element
        return file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    public function generateHardPasswords(string $current, int $length) : array {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = [];

        if ($length == 0) {
            return [$current];
        } else {
            for ($i = 0; $i < strlen($chars); $i++) {
                $newCurrent = $current . $chars[$i];
                $result = array_merge($result, $this->generateHardPasswords($newCurrent, $length - 1));

                // this is 1 billion, I was testing it with 1 million
                if (count($result) >= 1000000000) {
                    break;
                }
            }
        }
    
        return $result;
    }

    // Easy
    public function crackEasyPasswords(string $hashedPassword) : bool | string {
        for ($i = 10000; $i <= 99999; $i++) {
            if (md5($i . $this->salt) == $hashedPassword) {
                return $i;
            }
        }

        return false;
    }

    // Medium 1
    public function crackFirstTypeMediumPasswords(string $hashedPassword) : bool | string {
        for ($i = 0; $i <= 9; $i++) {
            foreach (range('A', 'Z') as $first) {
                foreach (range('A', 'Z') as $second) {
                    foreach (range('A', 'Z') as $third) {
                        $password = $first . $second . $third . $i;
                        if (md5($password . $this->salt) == $hashedPassword) {
                            return $password;
                        }
                    }
                }
            }
        }

        return false;
    }

    // Medium 2
    public function crackSecondTypeMediumPasswords(string $hashedPassword) : bool | string {
        foreach ($this->dictionaryWords as $word) {
            if (md5($word . $this->salt) == $hashedPassword) {
                return $word;
            }
        }

        return false;
    }

    // Hard
    public function crackHardPasswords(string $hashedPassword) : bool | string {
        foreach ($this->hardPasswords as $password) {
            if (md5($password . $this->salt) == $hashedPassword) {
                return $password;
            }
        }

        return false;
    }
}