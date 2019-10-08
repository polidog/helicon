<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class Hydrator implements HydratorInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     */
    public function __construct(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    public function hydrate(array $data, string $class): array
    {
        return array_map(function (array $row) use ($class) {
            $class = new $class();
            foreach (array_keys($row) as $key) {
                $this->propertyAccessor->setValue($class, $key, $row[$key]);
            }

            return $class;
        }, $data);
    }

    public function extract(array $objectArray): array
    {
        // TODO: Implement extract() method.
    }
}
