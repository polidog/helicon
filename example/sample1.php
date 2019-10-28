<?php

declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

use Polidog\Helicon\CollectionObjectMapper;
use Polidog\Helicon\Converter\Resolver;
use Polidog\Helicon\Converter\ScalarTypeConverter;
use Polidog\Helicon\Schema\Factory;
use Zend\Hydrator\ReflectionHydrator;

class Foo
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $age;
    /**
     * @var float
     */
    private $weight;

    /**
     * @param string $name
     * @param int    $age
     * @param float  $weight
     */
    public function __construct(string $name, int $age, float $weight)
    {
        $this->name = $name;
        $this->age = $age;
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }
}

$resolver = new Resolver();
$resolver->addConverter(new ScalarTypeConverter());
$factory = new Factory();
$reflectionHydrator = new ReflectionHydrator();

$arrayConverter = new Polidog\Helicon\ArrayConverter\Converter($resolver);
$mapper = new CollectionObjectMapper($arrayConverter, $factory, $reflectionHydrator);

$data = [
    [
        'name' => 'polidog',
        'age' => '33',
        'weight' => '88.4',
    ],
    [
        'name' => 'ahiru',
        'age' => 23,
        'weight' => 74.3,
    ],
];

$objects = ($mapper)($data, Foo::class);
var_dump($objects);
