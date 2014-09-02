<?php

namespace spec\mofodojodino\ProfanityFilter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserSpec extends ObjectBehavior
{
    public function it_detects_a_clean_string()
    {
        $this->hasProfanityCheck("clean string")->shouldReturn(false);
    }

    public function it_detects_blank_string_and_returns_false()
    {
        $this->hasProfanityCheck("")->shouldReturn(false);
    }

    public function it_detects_lowercase_profanity_in_string()
    {
        $this->hasProfanityCheck("you're-a cuntface")->shouldReturn(true);
    }

    public function it_detects_uppercase_profanity_in_string()
    {
        $this->hasProfanityCheck("youraCUNTface")->shouldReturn(true);
    }

    public function it_detects_profanity_with_u_substituted_with_ú_in_profanity()
    {
        $this->hasProfanityCheck("fúck")->shouldReturn(true);
    }

    public function it_detects_profanity_with_all_substituted_characters()
    {
        $this->hasProfanityCheck("ƒüćκ")->shouldReturn(true);
    }

    public function it_detects_profanity_with_all_characters_doubled_and_substituted()
    {
        $this->hasProfanityCheck("ƒƒüüććκκ")->shouldReturn(true);
    }

    public function it_detects_profanity_with_spaces_between()
    {
        $this->hasProfanityCheck("c u n t")->shouldReturn(true);
    }

    public function it_detects_false_for_words_without_profanity()
    {
        $this->hasProfanityCheck("I'm a nice person and I don't swear")->shouldReturn(false);
    }

    public function it_detects_profanity_with_pipes_between_characters()
    {
        $this->hasProfanityCheck("you're a c|u|n|t face")->shouldReturn(true);
    }

    public function it_detects_profanity_with_stars_between_characters()
    {
        $this->hasProfanityCheck("you're a c*u*n*t face")->shouldReturn(true);
    }

    public function it_detects_profanity_with_double_dashes_between_characters()
    {
        $this->hasProfanityCheck("c--u--n--t")->shouldReturn(true);
    }

    public function it_detects_profanity_with_dash_equals_between_characters()
    {
        $this->hasProfanityCheck("c-=u-=n-=t")->shouldReturn(true);
    }

    public function it_detects_profanity_with_all_punctuation_between_characters()
    {
        $spacers = array(
            ' ',
            '|',
            '!',
            '@',
            '#',
            '$',
            '%',
            '^',
            '&',
            '*',
            '(',
            ')',
            '-',
            '+',
            '_',
            '=',
            '{',
            '}',
            '[',
            ']',
            ':',
            ';',
            '\'',
            '"',
            '<',
            '>',
            '?',
            ',',
            '.',
            '/',
            '~',
            '`',
        );
        foreach ($spacers as $s) {
            $this->hasProfanityCheck("c{$s}u{$s}n{$s}t")->shouldReturn(true);
        }

        foreach ($spacers as $s) {
            $this->hasProfanityCheck("c{$s}{$s}u{$s}{$s}n{$s}{$s}t")->shouldReturn(true);
        }
    }
}
