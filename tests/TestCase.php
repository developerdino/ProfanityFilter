<?php

namespace Tests;

use DeveloperDino\ProfanityFilter\Check;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class TestCase extends PhpUnitTestCase
{
    /**
     * @var Check
     */
    protected $checker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checker = new Check();
    }
}