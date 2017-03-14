# Example

* We have a product cart
* Our cart can only contain products in stock
* Up to 3 products can be added to cart
* That latest rule does not apply during holidays
* During holidays products not in stock can also be added to cart

Let's assume we have a `Cart` object for which we want to add a `Product`, and we have a `Logger` service to record the process when it fails.

Lasagna code
------------
```php
$now = new DateTime();
if (($product->isInStock() || ($now >= new DateTime('First day of July') && $now < new DateTime('First day of September')))
    && (count($cart) < 3 || ($now >= new DateTime('First day of July') && $now < new DateTime('First day of September')))
) {
    $cart->addProduct($product);
}
else {
    $logger->debug("Unable to add product to cart, one of the conditions, don't know which one, failed.");
}
```

Specification
-------------

```php
# Product in stock specification

use BenTools\Specification\Specification;

class SpecProductInStock extends Specification
 {
 
     private $product;
 
     public function __construct(Product $product)
     {
         $this->product = $product;
     }
 
     /**
      * @inheritDoc
      */
     public function __invoke()
     {
         return $this->product->isInStock() or $this->callErrorCallback();
     }
 }
 
 $productIsInStock = SpecProductInStock::create($product)->otherwise(function () use ($logger) {
     $logger->debug('The product is not in stock.');
 });
```

```php
# Cart can accept products specification

use BenTools\Specification\Specification;

class SpecCartAcceptsNewProducts extends Specification
{

    private $cart;
    private $max;

    public function __construct(Cart $cart, int $max)
    {
        $this->cart = $cart;
        $this->max = $max;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function __invoke()
    {
        return count($this->cart) < $this->max or $this->callErrorCallback();
    }

}
$weCanAddProductsToCart = SpecCartAcceptsNewProducts::create($cart, 3)->otherwise(function (SpecCartAcceptsNewProducts $specification) use ($logger) {
    $logger->debug(sprintf('The cart already has %d products', count($specification->getCart())));
});

```

```php
# Holiday checker specification

use BenTools\Specification\Specification;

class SpecHolidayChecker extends Specification
{
    private $today;

    public function __construct(DateTime $today)
    {
        $this->today = $today;
    }

    public function __invoke()
    {
        return ($this->today >= new DateTime('First day of July')
            && $this->today < new DateTime('First day of September')) or $this->callErrorCallback();
    }
}
$weAreInHolidays = SpecHolidayChecker::create(new DateTime())->otherwise(function () use ($logger) {
    $logger->debug('Sad news, we are not on holidays now.');
});
```

```php
# Run specifications

$iCanAddProduct = BenTools\Specification\Helper\create($productIsInStock->orSuits($weAreInHolidays))
                    ->andSuits($weCanAddProductsToCart->orSuits($weAreInHolidays));

if ($iCanAddProduct()) {
    $cart->addProduct($product);
}
else {
    // The logger should have debug output
}
```

Of course this leads to way more code, just to wrap some (sometimes) simple conditions. **Do not do this everywhere!** 

The goal is to wrap every business rule into a logical, independent unit, allowing you to test each one and combine them.


Credits
-------

Thank you [Jean-François Lépine (fr)](http://blog.lepine.pro/php/gerer-des-regles-metiers-complexes-etou-changeantes/).