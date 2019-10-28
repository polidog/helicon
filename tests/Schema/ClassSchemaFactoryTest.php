<?php

declare(strict_types=1);

namespace Polidog\Helicon\Schema;

use PHPUnit\Framework\TestCase;

class ClassSchemaFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new Factory();
        $schema = $factory->create(DummySchema::class);
        $this->assertSame([
            'id' => [
                'type' => 'int',
            ],
            'name' => [
                'type' => 'string',
            ],
            'age' => [
                'type' => 'int',
            ],
            'score' => [
                'type' => 'float',
            ],
            'enable' => [
                'type' => 'bool',
            ],
        ], $schema);
    }
}

class DummySchema
{
    /**
     * @var int
     */
    private $id;

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
    private $score;

    /**
     * @var bool
     */
    private $enable;
}
