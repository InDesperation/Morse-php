<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'src/Morse.php';

class MorseTest extends \PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $my = new \Morse('TEST MESSAGE WITH WRONG NUMBER   OF    SPACES');
        $result = $my->encode();
        $expectedResult = '- · ··· -    -- · ··· ··· ·- --· ·    ·-- ·· - ····    ·-- ·-· --- -· --·    ' .
            '-· ··- -- -··· · ·-·    --- ··-·    ··· ·--· ·- -·-· · ···';
        $this->assertEquals($expectedResult, $result);
    }

    public function testDecode()
    {
        $my = new \Morse('- · ··· -    -- · ··· ··· ·- --· ·    ·-- ·· - ····    ·-- ·-· --- -· --·    ' .
            '-· ··- -- -··· · ·-·    --- ··-·    ··· ·--· ·- -·-· · ···');
        $result = $my->decode();
        $expectedResult = 'TEST MESSAGE WITH WRONG NUMBER OF SPACES';
        $this->assertEquals($expectedResult, $result);
    }

    public function testEncodeSpecialSymbols()
    {
        $my = new \Morse('SOS');
        $result = $my->encode();
        $expectedResult = '···---···';
        $this->assertEquals($expectedResult, $result);
    }

    public function testDecodeSpecialSymbols()
    {
        $my = new \Morse('········');
        $result = $my->decode();
        $expectedResult = 'SIGNING-ERROR';
        $this->assertEquals($expectedResult, $result);
    }

    public function testEncodeWithUnknownSymbols()
    {
        $my = new \Morse('$$$ 545 fsfds ^4fds');
        $result = $my->encode();
        $expectedResult = '$ $ $    ····· ····- ·····    ··-· ··· ··-· -·· ···    ^ ····- ··-· -·· ···';
        $this->assertEquals($expectedResult, $result);
    }

    public function testDecodeWithUnknownSymbols()
    {
        $my = new \Morse('$ $ $    ····· ····- ·····    ··-· ··· ··-· -·· ···    ^ ····- ··-· -·· ···');
        $result = $my->decode();
        $expectedResult = '$$$ 545 FSFDS ^4FDS';
        $this->assertEquals($expectedResult, $result);
    }

    public function testLowerCase()
    {
        $my = new \Morse('···· · ·-·· ·-·· --- ·-- --- ·-· ·-·· -·· -·-·--');
        $my->setCase(\Morse::LOWERCASE);
        $result = $my->decode();
        $expectedResult = 'helloworld!';
        $this->assertEquals($expectedResult, $result);
    }

    public function testUpperCase()
    {
        $my = new \Morse('···· · ·-·· ·-·· --- ·-- --- ·-· ·-·· -·· -·-·--');
        $my->setCase(\Morse::UPPERCASE);
        $result = $my->decode();
        $expectedResult = 'HELLOWORLD!';
        $this->assertEquals($expectedResult, $result);
    }

    public function testEqualSymbols()
    {
        $my = new \Morse('.·.. · ·-·· ·-·· -__ ·-- -—— ·-· ·-·· -·· -·-·--');
        $my->setCase(\Morse::UPPERCASE);
        $result = $my->decode();
        $expectedResult = 'HELLOWORLD!';
        $this->assertEquals($expectedResult, $result);
    }
}