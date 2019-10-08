<?php

declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\PropertyAccess\PropertyAccess;
use Polidog\Helicon\SimpleObjectHydrator;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }
}

$accessor = PropertyAccess::createPropertyAccessor();
$hydrator = new SimpleObjectHydrator($accessor);

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

$objects = $hydrator->hydrate($data, Foo::class);
var_dump($objects);
