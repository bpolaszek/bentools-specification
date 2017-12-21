# Example

* We have a product cart
* Our cart can only contain products in stock
* Up to 3 products can be added to cart
* That latest rule does not apply during holidays
* During holidays products not in stock can also be added to cart

Let's assume we have a `Cart` object for which we want to add a `Product`.

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
        $this->label = sprintf('Spec "product %s is in stock"', $product->getName());
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

```php
use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Specification;

class SpecCartIsNotFull extends Specification
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var int
     */
    private $maxProducts;

    /**
     * SpecCartIsNotLocked constructor.
     * @param Cart $cart
     * @param int  $maxProducts
     */
    public function __construct(Cart $cart, int $maxProducts)
    {
        $this->cart = $cart;
        $this->maxProducts = $maxProducts;
        $this->label = sprintf('Spec "cart contains less then %d products"', $maxProducts + 1);
    }

    /**
     * @inheritDoc
     */
    public function validate(): void
    {
        if (count($this->cart) > $this->maxProducts) {
            throw new UnmetSpecificationException($this);
        }
    }
}
```

```php
use BenTools\Specification\Exception\UnmetSpecificationException;
use BenTools\Specification\Specification;

class SpecTodayIsHoliday extends Specification
{
    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * SpecTodayIsHoliday constructor.
     */
    public function __construct(\DateTimeInterface $date = null)
    {
        $this->date = $date ?? new \DateTimeImmutable();
        $this->label = sprintf('Spec "date %s is in a holiday period"', $this->date->format('Y-m-d'));
    }

    /**
     * @inheritDoc
     */
    public function validate(): void
    {
        if (!($this->date >= new \DateTimeImmutable('First day of July')
            && $this->date < new \DateTimeImmutable('First day of September'))) {
            throw new UnmetSpecificationException($this);
        }
    }
}
```

### Now, play!

```php
use BenTools\Specification\Exception\UnmetSpecificationException;
use function BenTools\Specification\group;
use BenTools\Specification\Specification;

$products = [
    new Product($name = 'Iphone X', $inStock = true),
    new Product($name = 'Samsung Note', $inStock = true),
    new Product($name = 'Galaxy Edge', $inStock = false),
    new Product($name = 'Sony Xperia', $inStock = true),
];

$cart = new Cart();
$today = new \DateTimeImmutable();

$cartIsNotFull = new SpecCartIsNotFull($cart, 3);
$todayIsInHoliday = new SpecTodayIsHoliday($today);

$cartCanBeFilled = group($cartIsNotFull->or($todayIsInHoliday));
foreach ($products as $product) {
    $productCanBeBought = group($todayIsInHoliday->or(new SpecProductInStock($product)));
    try {
        $cartCanBeFilled->and($productCanBeBought)->validate();
        $cart->add($product);
    } catch (UnmetSpecificationException $e) {
        foreach ($e->getUnmetSpecifications() as $unmetSpecification) {
            if (null !== $unmetSpecification->getLabel()) {
                printf('%s failed.' . PHP_EOL, $unmetSpecification->getLabel());
            }
        }
        print 'FATAL ERROR'; die; // Do not do this at home
    }
}
```


Credits
-------

Thank you [Jean-François Lépine (fr)](http://blog.lepine.pro/php/gerer-des-regles-metiers-complexes-etou-changeantes/).