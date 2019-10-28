<?php

declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

use Polidog\Helicon\ObjectMapper;
use Polidog\Helicon\TypeCaster\Resolver;
use Polidog\Helicon\TypeCaster\ScalarTypeCaster;
use Polidog\Helicon\Schema\ObjectSchemaFactory;
use Polidog\Helicon\ArrayMapper;
use Polidog\Helicon\Schema\JsonSchemaFileFactory;
use Polidog\Helicon\TypeCaster\NumberTypeCaster;

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
$resolver->addConverter(new ScalarTypeCaster());
$resolver->addConverter(new NumberTypeCaster());

$factory = new ObjectSchemaFactory();
$reflectionHydrator = new ReflectionHydrator();

$converter = new Polidog\Helicon\Converter\Converter($resolver);

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

$objects = (new ObjectMapper($converter, $factory, $reflectionHydrator))($data, Foo::class);
var_dump($objects);

// array mapper
$arrays = (new ArrayMapper($converter, $factory))($data, Foo::class);
var_dump($arrays);

// using json schema file
$arrays2 = (new ArrayMapper($converter, new JsonSchemaFileFactory()))($data, __DIR__.'/schema.json');
var_dump($arrays2);

