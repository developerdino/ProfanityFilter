<?php


namespace Tests;

use DeveloperDino\ProfanityFilter\Check;

/**
 * Description of ProfanityFilterTest
 *
 * @author Jack Cheung <jack@jackcheung.com>
 */
class ProfanityFilterTest extends TestCase
{
    public function testProfanityCheck()
    {
        $this->assertTrue($this->checker->hasProfanity('such a dumbass'));
        $this->assertFalse($this->checker->hasProfanity('this is a clean sentence'));
    }

    public function testProfanityObfuscation()
    {
        $cleaned = $this->checker->obfuscateIfProfane('such a dumbass');
        $expected = '**************';
        $this->assertEquals($cleaned, $expected);

        $cleaned = $this->checker->obfuscateIfProfane('this is a clean sentence');
        $expected = 'this is a clean sentence';
        $this->assertEquals($cleaned, $expected);
    }

    public function testLoadCustomWordsFromArray()
    {
        $check = new Check(['dirty', 'word']);
        $this->assertTrue($check->hasProfanity('this sentence is dirty'));
        $this->assertFalse($check->hasProfanity('but this one is clean'));
    }

    public function testLoadCustomWordsFromFile()
    {
        $check = new Check(__DIR__ . '/profanities.php');
        $this->assertTrue($check->hasProfanity('this sentence is dirty'));
        $this->assertFalse($check->hasProfanity('but this one is clean'));
    }
}
