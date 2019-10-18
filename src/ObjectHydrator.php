<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Polidog\Helicon\ArrayConverter\Converter;
use Polidog\Helicon\SchemaFactory\ClassSchemaFactory;
use Zend\Hydrator\ReflectionHydrator;

class ObjectHydrator implements HydratorInterface
{
    /**
     * @var Converter
     */
    private $arrayConverter;

    /**
     * @var ClassSchemaFactory
     */
    private $schemaFactory;

    /**
     * @var ReflectionHydrator
     */
    private $reflectionHydrator;

    /**
     * @param Converter          $arrayConverter
     * @param ClassSchemaFactory $schemaFactory
     * @param ReflectionHydrator $reflectionHydrator
     */
    public function __construct(Converter $arrayConverter, ClassSchemaFactory $schemaFactory, ReflectionHydrator $reflectionHydrator)
    {
        $this->arrayConverter = $arrayConverter;
        $this->schemaFactory = $schemaFactory;
        $this->reflectionHydrator = $reflectionHydrator;
    }

    /**
     * @param array  $data
     * @param string $schema
     *
     * @return array
     */
    public function hydrate(array $data, string $schema): array
    {
        return array_map(function (array $row) use ($schema) {
            $schemaArray = $this->schemaFactory->create($schema);

            return $this->reflectionHydrator->hydrate(
                $this->arrayConverter->convert($row, $schemaArray),
                (new \ReflectionClass($schema))->newInstanceWithoutConstructor()
            );
        }, $data);
    }

    public function extract(array $objectArray): array
    {
        // TODO: Implement extract() method.
    }
}
