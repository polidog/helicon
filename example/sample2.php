<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use Polidog\Helicon\ObjectHydrator;
use Zend\Hydrator\ReflectionHydrator;

class Foo
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Bar
     */
    private $bar;
}

class Bar
{
    /**
     * @var int
     */
    private $level;
}

$reflectionHydrator = new ReflectionHydrator();
$hydrator = new ObjectHydrator($reflectionHydrator);

$data = [
    [
        'name' => 'polidog',
        'bar' => [
            'level' => 1,
        ],
    ],
];

$objects = $hydrator->hydrate($data, Foo::class);
var_dump($objects);
