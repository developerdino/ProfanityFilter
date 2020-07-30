<?php

namespace Tests;


use Generator;

class CheckTest extends TestCase
{
    /**
     * @test
     */
    public function itDetectsACleanString()
    {
        $this->assertFalse($this->checker->hasProfanity("clean string"));
    }

    /**
     * @test
     */
    public function itDetectsBlankStringAndReturnsFalse()
    {
        $this->assertFalse($this->checker->hasProfanity(""));
    }

    /**
     * @test
     */
    public function itDetectsLowercaseProfanityInString()
    {
        $this->assertTrue($this->checker->hasProfanity("you're-a cuntface"));
    }

    /**
     * @test
     */
    public function itDetectsUppercaseProfanityInString()
    {
        $this->assertTrue($this->checker->hasProfanity("youraCUNTface"));
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithUSubstitutedWithÚInProfanity()
    {
        $this->assertTrue($this->checker->hasProfanity("fúck"));
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithAllSubstitutedCharacters()
    {
        $this->assertTrue($this->checker->hasProfanity("ƒüćκ"));;
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithAllCharactersDoubledAndSubstituted()
    {
        $this->assertTrue($this->checker->hasProfanity("ƒƒüüććκκ"));
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithSpacesBetween()
    {
        $this->assertTrue($this->checker->hasProfanity("c u n t"));
    }

    /**
     * @test
     */
    public function itDetectsFalseForWordsWithoutProfanity()
    {
        $this->assertFalse($this->checker->hasProfanity("I'm a nice person and I don't swear"));
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithPipesBetweenCharacters()
    {
        $this->assertTrue($this->checker->hasProfanity("you're a c|u|n|t face"));
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithStarsBetweenCharacters()
    {
        $this->assertTrue($this->checker->hasProfanity("you're a c*u*n*t face"));
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithDoubleDashesBetweenCharacters()
    {
        $this->assertTrue($this->checker->hasProfanity("c--u--n--t"));
    }

    /**
     * @test
     */
    public function itDetectsProfanityWithDashEqualsBetweenCharacters()
    {
        $this->assertTrue($this->checker->hasProfanity("c-=u-=n-=t"));
    }

    /**
     * @dataProvider spacers
     * @test
     * @param string $spacer
     */
    public function itDetectsProfanityWithAllPunctuationBetweenCharacters(string $spacer)
    {
        $this->assertTrue($this->checker->hasProfanity("c{$spacer}u{$spacer}n{$spacer}t"));
        $this->assertTrue($this->checker->hasProfanity("c{$spacer}{$spacer}u{$spacer}{$spacer}n{$spacer}{$spacer}t"));
        $this->assertTrue(
            $this->checker->hasProfanity("cc{$spacer}{$spacer}uu{$spacer}{$spacer}nn{$spacer}{$spacer}tt")
        );
    }

    /**
     * @test
     */
    public function itObfuscatesAStringThatContainsAProfanity()
    {
        $this->assertEquals('****', $this->checker->obfuscateIfProfane("cunt"));
    }

    /**
     * @test
     */
    public function itDoesNotDetectAsAsAProfanity()
    {
        $this->assertFalse($this->checker->hasProfanity("as"));
        $this->assertFalse($this->checker->hasProfanity("a.s."));
        $this->assertFalse($this->checker->hasProfanity("a s"));
        $this->assertFalse($this->checker->hasProfanity("a .s ."));
    }

    /**
     * @test
     */
    public function itDoesDetectAssAsAProfanity()
    {
        $this->assertTrue($this->checker->hasProfanity("ass"));
        $this->assertTrue($this->checker->hasProfanity("a s s "));
        $this->assertTrue($this->checker->hasProfanity("a 's [s ["));
        $this->assertTrue($this->checker->hasProfanity("a$ 's$ [s$ ["));
    }

    /**
     * @test
     */
    public function itDoesDetectProfanitiesInDirtyWordsWithSpacesBetweenLetters()
    {
        $this->assertTrue($this->checker->hasProfanity("c u n t"));
        $this->assertTrue($this->checker->hasProfanity("f  u  c  k"));
    }

    /**
     * @test
     */
    public function itDoesNotDetectProfanitiesInCleanStringsWithSpacesBetweenLetters()
    {
        $this->assertFalse($this->checker->hasProfanity("r i g h t"));
        $this->assertFalse($this->checker->hasProfanity("h e l l o"));
    }

    /**
     * @return Generator
     */
    public function spacers(): Generator
    {
        yield [' '];
        yield ['|'];
        yield ['!'];
        yield ['@'];
        yield ['#'];
        yield ['$'];
        yield ['%'];
        yield ['^'];
        yield ['&'];
        yield ['*'];
        yield ['('];
        yield [')'];
        yield ['-'];
        yield ['+'];
        yield ['_'];
        yield ['='];
        yield ['{'];
        yield ['}'];
        yield ['['];
        yield [']'];
        yield [':'];
        yield [';'];
        yield ['\''];
        yield ['"'];
        yield ['<'];
        yield ['>'];
        yield ['?'];
        yield [','];
        yield ['.'];
        yield ['/'];
        yield ['~'];
        yield ['`'];
    }
}
