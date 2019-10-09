<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Zend\Hydrator\ReflectionHydrator;

class ObjectHydrator implements Hydrator
{
    /**
     * @var ReflectionHydrator
     */
    private $reflectionHydrator;

    /**
     * @param ReflectionHydrator $reflectionHydrator
     */
    public function __construct(ReflectionHydrator $reflectionHydrator)
    {
        $this->reflectionHydrator = $reflectionHydrator;
    }

    public function hydrate(array $data, string $schema): array
    {
        return array_map(function (array $row) use ($schema) {
            return $this->reflectionHydrator->hydrate(
                $row,
                (new \ReflectionClass($schema))->newInstanceWithoutConstructor()
            );
        }, $data);
    }

    public function extract(array $objectArray): array
    {
        // TODO: Implement extract() method.
    }
}
