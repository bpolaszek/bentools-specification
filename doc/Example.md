# Example

* We have a product cart
* Our cart can only contain products in stock
* Up to 3 products can be added to cart
* That latest rule does not apply during holidays
* During holidays products not in stock can also be added to cart

Let's assume we have a `Cart` object for which we want to add a `Product`, and we have a `Logger` service to record the process when it fails.

The challenge
-------------

All these combined conditions can lead to unreadable code, and if one of these conditions fails, it may be hard to isolate it.

We'll try to add **a product that is not in stock**, into an **empty cart**, **out of holidays**. 

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

    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @inheritDoc
     */
    public function __invoke()
    {
        return $this->product->isInStock();
    }
}

$productIsInStock = SpecProductInStock::create($product)->otherwise(function (SpecProductInStock $spec) use ($logger) {
    $logger->debug('The product is not in stock.', ['product' => $spec->getProduct()]);
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
        $this->max  = $max;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function __invoke()
    {
        return count($this->cart) < $this->max;
    }

}
$weCanAddProductsToCart = SpecCartAcceptsNewProducts::create($cart, 3)->otherwise(function (SpecCartAcceptsNewProducts $spec) use ($logger) {
    $logger->debug(sprintf('The cart already has %d products', count($spec->getCart())), ['cart' => $spec->getCart()]);
});

```

```php
# Holiday checker specification

use BenTools\Specification\Specification;

class SpecHolidayChecker extends Specification
{
    private $today;

    public function __construct(DateTimeInterface $today)
    {
        $this->today = $today;
    }

    public function __invoke()
    {
        return ($this->today >= new DateTime('First day of July')
            && $this->today < new DateTime('First day of September'));
    }
}
$weAreInHolidays = SpecHolidayChecker::create(new DateTime())->otherwise(function () use ($logger) {
    $logger->debug('Sad news, we are not on holidays now.');
});
```

```php
# Run specifications

$productCanBeBought = $productIsInStock->orSuits($weAreInHolidays)->otherwise(function () use ($logger) {
    $logger->info('Buying this product is impossible.');
});

$cartCanBeFilled    = $weCanAddProductsToCart->orSuits($weAreInHolidays)->otherwise(function () use ($logger) {
    $logger->info('Filling the cart is impossible.');
});

$iCanAddProductToCart = $productCanBeBought->andSuits($cartCanBeFilled)->otherwise(function () use ($logger) {
    $logger->info('An error occured');
});


if ($iCanAddProductToCart()) {
    $cart->addProduct($product);
}
else {
    $iCanAddProductToCart->callErrorCallback(true); // Passing true allows cascading the otherwise() chain
    // The logger should have the following output:
    // [INFO] An error occured
    // [INFO] Buying this product is impossible.
    // [DEBUG] The product is not in stock.
}
```

Of course this leads to way more code (and this example is voluntarily complex), just to wrap some (sometimes) simple conditions. **Do not do this everywhere!** 

The goal is to wrap every business rule into a logical, independent unit, allowing you to test each one and combine them.


Credits
-------

Thank you [Jean-François Lépine (fr)](http://blog.lepine.pro/php/gerer-des-regles-metiers-complexes-etou-changeantes/).