<?php

namespace Tests;

class NotProfaneTest extends TestCase
{
    /**
     * @dataProvider phrases
     * @test
     * @param string $phrase
     */
    public function shouldNotTestPositiveToProfanity(string $phrase)
    {
        $this->assertFalse($this->checker->hasProfanity($phrase), "Phrase '{$phrase}' should not be profane!");
    }

    public function phrases()
    {
        yield ['album'];
        yield ['anthony'];
        yield ['assignment'];
        yield ['analytics'];
        yield ['as sure'];
        yield ['coke'];
        yield ['document'];
        yield ['get it'];
        yield ['hows it going'];
        yield ['i have a hole in my pocket'];
        yield ['madison bumgardner'];
        yield ['Mick'];
        yield ['scrape'];
        yield ['shoe'];
    }
}
