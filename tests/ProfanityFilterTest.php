<?php

use mofodojodino\ProfanityFilter\Check;

/**
 * Description of ProfanityFilterTest
 *
 * @author Jack Cheung <jack@jackcheung.com>
 */
class ProfanityFilterTest extends \PHPUnit_Framework_TestCase {

    public $tester;
    
    public function testProfanityCheck() {
        $check = new Check();
        $this->assertTrue($check->hasProfanity('such a dumbass'));
        $this->assertFalse($check->hasProfanity('this is a clean sentence'));
    }
    
    public function testProfanityObfuscation() {
        $check = new Check();
        
        $cleaned = $check->obfuscateIfProfane('such a dumbass');
        $expected = '**************';
        $this->assertEquals($cleaned, $expected);
        
        $cleaned = $check->obfuscateIfProfane('this is a clean sentence');
        $expected = 'this is a clean sentence';
        $this->assertEquals($cleaned, $expected);
    }
    
    public function testLoadCustomWordsFromArray() {
        $check = new Check(array('dirty', 'word'));
        $this->assertTrue($check->hasProfanity('this sentence is dirty'));
        $this->assertFalse($check->hasProfanity('but this one is clean'));
    }
    
    public function testLoadCustomWordsFromFile() {
        $check = new Check(__DIR__ . '/profanities.php');
        $this->assertTrue($check->hasProfanity('this sentence is dirty'));
        $this->assertFalse($check->hasProfanity('but this one is clean'));
    }
}
