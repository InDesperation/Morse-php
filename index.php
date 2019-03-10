<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Morse.php';

$encodeExample = new \Morse('Not a single function but a class! SOS');
$encodeExampleResult = $encodeExample->encode();

$decodeExample = new \Morse($encodeExampleResult);
$decodeExampleUpResult = $decodeExample->decode();
$decodeExample->setCase(\Morse::LOWERCASE);
$decodeExampleLowResult = $decodeExample->decode();
print 'Encoded: ' . $encodeExampleResult . '<br>';
print 'Decoded uppercase: ' . $decodeExampleUpResult . '<br>';
print 'Decoded lowercase: ' . $decodeExampleLowResult;