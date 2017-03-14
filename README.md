[![Latest Stable Version](https://poser.pugx.org/bentools/specification/v/stable)](https://packagist.org/packages/bentools/specification)
[![License](https://poser.pugx.org/bentools/specification/license)](https://packagist.org/packages/bentools/specification)
[![Build Status](https://img.shields.io/travis/bpolaszek/bentools-specification/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/bentools-specification)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/bentools-specification/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/bentools-specification?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/bentools-specification.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification)
[![Total Downloads](https://poser.pugx.org/bentools/specification/downloads)](https://packagist.org/packages/bentools/specification)

# bentools/specification

PHP7.0+ implementation of the Specification Pattern.

The goal
--------
The Specification Pattern allows you to wrap some conditionnal structures into value objects. 
This may have no sense in your usual code, but it can be useful when the combination of your business rules 
reaches a high [Cyclomatic Complexity](https://en.wikipedia.org/wiki/Cyclomatic_complexity).

Thus, wrapping your conditions into named objects with a specific failure handling may help you to:
* Add new business rules to existing ones
* Have a better understanding of your conditionnal structures
* Find which condition invalidates the others
* Avoid unreadable lasagna-code

The principles of the Specification Pattern are borrowed from Domain Driven Design, but can be applied anywhere.

Overview
--------
Every `Specification` object implements the [`__invoke()`](http://php.net/manual/en/language.oop5.magic.php#object.invoke) method that must return a boolean.
If the boolean is false, a callback can be called (provided earlier in the `otherwise()` method).

```php

require_once __DIR__ . '/vendor/autoload.php';

use function BenTools\Specification\Helper\bool as booleanSpec;
use function BenTools\Specification\Helper\callback as callbackSpec;

$condition1 = booleanSpec((bool) random_int(0, 1))->otherwise(function () {
    var_dump('Condition 1 failed.');
});

$condition2 = callbackSpec(function () {
    return (bool) random_int(0, 1);
})->otherwise(function () {
    var_dump('Condition 2 failed.');
});;

$conditions = $condition1->andSuits($condition2);
var_dump($conditions());
```

Advanced Example
----------------
Since the Specification Pattern is intended to test your business rules, you should better implement your own `Specification` classes.

See our [example](doc/Example.md) to get started.

Installation
------------

```
composer require bentools/specification
```

License
-------
MIT