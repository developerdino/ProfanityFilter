<?php

namespace mofodojodino\ProfanityFilter;

class Check
{
    /**
     * Regular expression for checking between swear word characters
     */
    const IN_BETWEEN_REGEX = '[\\s|\||!|@|#|\$|%|^|&|\*|\(|\)|\-|+|_|=|\{|\}|\[|\]|:|;|\'|\"|<|>|\?|,|\.|\/|~|`]*';

    /**
     * List of bad words to test against
     *
     * @var array
     */
    protected $badwords = array();

    /**
     * List of potential character substitutions as a regular expression.
     *
     * @var array
     */
    protected $replacements = array(
        '/a/' => '(a|a\.|a\-|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|æ|Æ|α|Δ|Λ|λ)+{$}',
        '/b/' => '(b|b\.|b\-|8|\|3|ß|Β|β)+{$}',
        '/c/' => '(c|c\.|c\-|Ç|ç|ć|Ć|č|Č|¢|€|<|\(|{|©)+{$}',
        '/d/' => '(d|d\.|d\-|&part;|\|\)|Þ|þ|Ð|ð)+{$}',
        '/e/' => '(e|e\.|e\-|3|€|È|è|É|é|Ê|ê|ë|Ë|ē|Ē|ė|Ė|ę|Ę|∑)+{$}',
        '/f/' => '(f|f\.|f\-|ƒ)+{$}',
        '/g/' => '(g|g\.|g\-|6|9)+{$}',
        '/h/' => '(h|h\.|h\-|Η)+{$}',
        '/i/' => '(i|i\.|i\-|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï|ī|Ī|į|Į)+{$}',
        '/j/' => '(j|j\.|j\-)+{$}',
        '/k/' => '(k|k\.|k\-|Κ|κ)+{$}',
        '/l/' => '(l|1\.|l\-|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï|ł|Ł)+{$}',
        '/m/' => '(m|m\.|m\-)+{$}',
        '/n/' => '(n|n\.|n\-|η|Ν|Π|ñ|Ñ|ń|Ń)+{$}',
        '/o/' => '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø|ô|Ô|ö|Ö|ò|Ò|ó|Ó|œ|Œ|ø|Ø|ō|Ō|õ|Õ)+{$}',
        '/p/' => '(p|p\.|p\-|ρ|Ρ|¶|þ)+{$}',
        '/q/' => '(q|q\.|q\-)+{$}',
        '/r/' => '(r|r\.|r\-|®)+{$}',
        '/s/' => '(s|s\.|s\-|5|\$|§|ß|Ś|ś|Š|š)+{$}',
        '/t/' => '(t|t\.|t\-|Τ|τ)+{$}',
        '/u/' => '(u|u\.|u\-|υ|µ|û|ü|ù|ú|ū|Û|Ü|Ù|Ú|Ū)+{$}',
        '/v/' => '(v|v\.|v\-|υ|ν)+{$}',
        '/w/' => '(w|w\.|w\-|ω|ψ|Ψ)+{$}',
        '/x/' => '(x|x\.|x\-|Χ|χ)+{$}',
        '/y/' => '(y|y\.|y\-|¥|γ|ÿ|ý|Ÿ|Ý)+{$}',
        '/z/' => '(z|z\.|z\-|Ζ|ž|Ž|ź|Ź|ż|Ż)+{$}',
    );

    /**
     * @param null $config
     */
    public function __construct($config = null)
    {
        if ($config === null) {
            $config = __DIR__ . '/../../../config/badwords.php';
        }

        $this->badwords = $this->loadBadwordsFromFile($config);
    }

    /**
     * Checks string for profanities based on list 'badwords'
     *
     * @param $string
     *
     * @return bool
     */
    public function hasProfanity($string)
    {
        if (empty($string)) {
            return false;
        }

        $badwords = array();
        $badwordsCount = count($this->badwords);

        for ($i = 0; $i < $badwordsCount; $i++) {
            $badwords[ $i ] = '/' . preg_replace(
                    array_keys($this->replacements),
                    array_values($this->replacements),
                    $this->badwords[ $i ]
                ) . '/i';
            $badwords[ $i ] = str_replace('{$}', self::IN_BETWEEN_REGEX, $badwords[ $i ]);
        }

        foreach ($badwords as $profanity) {
            if ($this->stringHasProfanity($string, $profanity)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obfuscates string that contains a 'badword'
     *
     * @param $string
     *
     * @return string
     */
    public function obfuscateIfProfane($string)
    {
        if ($this->hasProfanity($string)) {
            $string = str_repeat("*", strlen($string));
        }

        return $string;
    }

    /**
     * Checks a string against a profanity.
     *
     * @param $string
     * @param $profanity
     *
     * @return bool
     */
    private function stringHasProfanity($string, $profanity)
    {
        return preg_match($profanity, $string) === 1;
    }

    /**
     * Load 'badwords' from config file.
     *
     * @param $config
     *
     * @return array
     */
    private function loadBadwordsFromFile($config)
    {
        return include($config);
    }
}
