[![Latest Stable Version](https://poser.pugx.org/bentools/specification/v/stable)](https://packagist.org/packages/bentools/specification)
[![License](https://poser.pugx.org/bentools/specification/license)](https://packagist.org/packages/bentools/specification)
[![Build Status](https://api.travis-ci.org/bpolaszek/bentools-specification.svg?branch=master)](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification/build-status/master)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/bentools-specification/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/bentools-specification?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bpolaszek/bentools-specification/?branch=master)
[![Total Downloads](https://poser.pugx.org/bentools/specification/downloads)](https://packagist.org/packages/bentools/specification)

# bentools/specification

PHP7.1+ implementation of the Specification Pattern.

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
A specification is a kind of enhanced conditionnal structure, which can be chained to other specifications.

Here's how to create a specification:

```php
require_once __DIR__ . '/vendor/autoload.php';

use function BenTools\Specification\spec;

$color = 'green';
$spec = spec('green' === $color);
$spec->validate(); // Hurray! Our specification has been validated.
```

As you can see, the `validate()` method is used to validate a specification is met. It returns `void` (nothing). 

When a specification is unmet, the `validate()` method throws an `UnmetSpecificationException`:

```php
use function BenTools\Specification\spec;

$color = 'green';
$size = 'small';
$spec = spec('green' === $color)->and('big' === $size);
$spec->validate(); // Oh no! An UnmetSpecificationException has been thrown.
```

When handling these exceptions, you can know which specification(s) failed. To identify them, you can name each specification:
```php
use BenTools\Specification\Exception\UnmetSpecificationException;
use function BenTools\Specification\spec;

$color = 'green';
$size = 'small';

$spec = spec('green' === $color)->withLabel('Color specification')
            ->and('big' === $size)->withLabel('Size specification');
try {
    $spec->validate();
} catch (UnmetSpecificationException $e) {
    foreach ($e->getUnmetSpecifications() as $unmetSpecification) {
        if (null !== $unmetSpecification->getLabel()) {
            printf('%s failed.' . PHP_EOL, $unmetSpecification->getLabel());
        }
    }
}

// Outputs: Size specification failed.
```

#### Create specifications

The `spec()`, `group()` and `not()` functions, and the `and()` and `or()` methods are Specification factories, that will return a `Specification` object. They accept as an argument:

* A boolean
* A callable that will resolve to a boolean
* An existing `Specification object`

Examples:

```php
use function BenTools\Specification\spec;
use function BenTools\Specification\group;
use function BenTools\Specification\not;

spec(true); // Specification met
not(false); // Specification met
not(spec(function () {
    return false;
})); // Specification met
group(not(spec(false))->or(true)); // Specification met
```

#### Group and Chain specifications

A `Specification` object contains `and` and `or` methods that can be used to create composite specifications. You can also use the `group()` function which will behave like parenthesis:

```php
use function BenTools\Specification\spec;
use function BenTools\Specification\group;
use function BenTools\Specification\not;

spec(true)
    ->and(
        group(
            spec(true)->or(false)
        )
        ->or(
            not(false)
        )
    ); // Specification met
```

#### Create your own specifications
Since the Specification Pattern is intended to test your business rules, you can extend the abstract `Specification` class to create your own objects instead of relying on simple booleans:

```php
use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Specification;

class SpecProductInStock extends Specification
{
    /**
     * @var Product
     */
    private $product;

    /**
     * SpecProductInStock constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->label = sprintf('Product %s in stock verification', $product->getName());
    }

    /**
     * Validate the specification.
     * If the specification is unmet the implementation MUST throw an UnmetSpecificationException.
     *
     * @throws UnmetSpecificationException
     */
    public function validate(): void
    {
        if (false === $this->product->isInStock()) {
            throw new UnmetSpecificationException($this);
        }
    }
}
```

Advanced Example
----------------
Since the Specification Pattern is intended to test your business rules, you should better implement your own `Specification` classes.

See our [example](doc/Example.md) to get started.

Installation
------------

```
composer require bentools/specification ^3.0
```

License
-------
MIT