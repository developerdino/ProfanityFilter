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

# Installation

##### Install this package via composer.

```
php composer.phar require mofodojodino/profanity-filter
```

# Usage

##### Checks string for profanities based on 'badwords' list:
```
use mofodojodino\ProfanityFilter\Check;
...
class Whatever
{
    $string = 'badword';
    $profanity = new Check();
    if($profanity->hasProfanity($string))
        return "This string contains a profanity";
```

##### Replace string with '*' if profanity found
```
    $filteredString = $profanity->filterProfanity($string);
```

##### Replace names with '*' if profanity found (it will also check strings concatenation)
```
    $filtered          = $profanity->filterNames($firstName, $lastName);
    $filteredFirstName = $filtered['firstName'];
    $filteredLastName  = $filtered['lastName'];
```

## Kudos

Have to mention the following project as it gave me a good foundation for the regex and a list of swear words.

https://github.com/fastwebmedia/Profanity-Filter

### License

ProfanityFilter is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
