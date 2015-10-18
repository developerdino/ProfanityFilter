<?php

namespace spec\mofodojodino\ProfanityFilter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CheckSpec extends ObjectBehavior
{
    public function it_detects_a_clean_string()
    {
        $this->hasProfanity("clean string")->shouldReturn(false);
    }

    public function it_detects_blank_string_and_returns_false()
    {
        $this->hasProfanity("")->shouldReturn(false);
    }

    public function it_detects_lowercase_profanity_in_string()
    {
        $this->hasProfanity("you're-a cuntface")->shouldReturn(true);
    }

    public function it_detects_uppercase_profanity_in_string()
    {
        $this->hasProfanity("youraCUNTface")->shouldReturn(true);
    }

    public function it_detects_profanity_with_u_substituted_with_ú_in_profanity()
    {
        $this->hasProfanity("fúck")->shouldReturn(true);
    }

    public function it_detects_profanity_with_all_substituted_characters()
    {
        $this->hasProfanity("ƒüćκ")->shouldReturn(true);
    }

    public function it_detects_profanity_with_all_characters_doubled_and_substituted()
    {
        $this->hasProfanity("ƒƒüüććκκ")->shouldReturn(true);
    }

    public function it_detects_profanity_with_spaces_between()
    {
        $this->hasProfanity("c u n t")->shouldReturn(true);
    }

    public function it_detects_false_for_words_without_profanity()
    {
        $this->hasProfanity("I'm a nice person and I don't swear")->shouldReturn(false);
    }

    public function it_detects_profanity_with_pipes_between_characters()
    {
        $this->hasProfanity("you're a c|u|n|t face")->shouldReturn(true);
    }

    public function it_detects_profanity_with_stars_between_characters()
    {
        $this->hasProfanity("you're a c*u*n*t face")->shouldReturn(true);
    }

    public function it_detects_profanity_with_double_dashes_between_characters()
    {
        $this->hasProfanity("c--u--n--t")->shouldReturn(true);
    }

    public function it_detects_profanity_with_dash_equals_between_characters()
    {
        $this->hasProfanity("c-=u-=n-=t")->shouldReturn(true);
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
            $this->hasProfanity("c{$s}u{$s}n{$s}t")->shouldReturn(true);
            $this->hasProfanity("c{$s}{$s}u{$s}{$s}n{$s}{$s}t")->shouldReturn(true);
            $this->hasProfanity("cc{$s}{$s}uu{$s}{$s}nn{$s}{$s}tt")->shouldReturn(true);
        }
    }

    public function it_obfuscates_a_string_that_contains_a_profanity()
    {
        $this->obfuscateIfProfane("cunt")->shouldReturn("****");
    }

    public function it_does_not_detect_as_as_a_profanity()
    {
        $this->hasProfanity("as")->shouldReturn(false);
        $this->hasProfanity("a.s.")->shouldReturn(false);
        $this->hasProfanity("a s")->shouldReturn(false);
        $this->hasProfanity("a .s .")->shouldReturn(false);
    }

    public function it_does_detect_ass_as_a_profanity()
    {
        $this->hasProfanity("ass")->shouldReturn(true);
        $this->hasProfanity("a s s ")->shouldReturn(true);
        $this->hasProfanity("a 's [s [")->shouldReturn(true);
        $this->hasProfanity("a$ 's$ [s$ [")->shouldReturn(true);
    }

    public function it_does_detect_profanities_in_dirty_words_with_spaces_between_letters()
    {
        $this->hasProfanity("c u n t")->shouldReturn(true);
        $this->hasProfanity("f  u  c  k")->shouldReturn(true);
    }

    public function it_does_not_detect_profanities_in_clean_strings_with_spaces_between_letters()
    {
        $this->hasProfanity("r i g h t")->shouldReturn(false);
        $this->hasProfanity("h e l l o")->shouldReturn(false);
    }

    public function it_does_not_detect_ho_as_profanity_in_anthony()
    {
        $this->hasProfanity("anthony")->shouldReturn(false);
    }

    public function it_does_not_detect_mick_as_a_swear_word()
    {
        $this->hasProfanity("Mick")->shouldReturn(false);
    }
}
