<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class SimpleObjectHydrator implements Hydrator
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

    public function hydrate(array $data, string $schema): array
    {
        return array_map(function (array $row) use ($schema) {
            $schema = new $schema();
            foreach (array_keys($row) as $key) {
                $this->propertyAccessor->setValue($schema, $key, $row[$key]);
            }

            return $schema;
        }, $data);
    }

    public function extract(array $objectArray): array
    {
        // TODO: Implement extract() method.
    }
}
