[![Build Status](https://travis-ci.org/mofodojodino/ProfanityFilter.svg?branch=develop)](https://travis-ci.org/mofodojodino/ProfanityFilter)

## Profanity Filter

A simple class to test if a string has a profanity in it.

## Checks performed

### Straight matching

Checks string for profanity as it is against list of bad words. E.g. `badword`

### Substitution

Checks string for profanity with characters substituted for each letter. E.g. `bâdΨ0rd`

### Obscured

Checks string for profanity obscured with punctuation between. E.g. `b|a|d|w|o|r|d`

### Doubled

Check string for profanity that has characters doubled up. E.g. `bbaaddwwoorrdd`

### Combinations

Also works with combinations of the above. E.g. `b|â|d|Ψ|0|rr|d`

## Installation

Install this package via composer.

```
php composer.phar require mofodojodino/profanity-filter
```

## Usage
```php
/* default constructor */
$check = new Check();
$hasProfanity = $check->hasProfanity($badWords);
$cleanWords = $check->obfuscateIfProfane($badWords);

/* customized word list from file */
$check = new Check('path.to/wordlist.php');

/* customized word list from array */
$badWords = array('bad', 'words') // or load from db
$check = new Check($badWords);
```

## Kudos

Have to mention the following project as it gave me a good foundation for the regex and a list of swear words.

https://github.com/fastwebmedia/Profanity-Filter

Thanks to @jackcsk for his contribution, adding the ability to use a plain array instead of a file for the list of profanities. Available in version > v1.3.0.

### License

ProfanityFilter is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
