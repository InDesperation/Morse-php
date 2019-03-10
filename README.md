# morse-php

Class to encode/decode morse code

# Usage
$my = new \Morse('string');  
$result = $my->encode();

$my = new \Morse('...-_-...');  
$my->setCase(\Morse::LOWERCASE);  
$result = $my->decode();