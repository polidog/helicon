<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Polidog\Helicon\Converter\Converter;
use Polidog\Helicon\Schema\Factory;
use Zend\Hydrator\ReflectionHydrator;

class Mapper implements MapperInterface
{
    /**
     * @var Converter
     */
    private $arrayConverter;

    /**
     * @var Factory
     */
    private $schemaFactory;

    /**
     * @var ReflectionHydrator
     */
    private $reflectionHydrator;

    /**
     * @param Converter          $arrayConverter
     * @param Factory            $schemaFactory
     * @param ReflectionHydrator $reflectionHydrator
     */
    public function __construct(Converter $arrayConverter, Factory $schemaFactory, ReflectionHydrator $reflectionHydrator)
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
    public function __invoke(array $data, string $schema): array
    {
        return array_map(function (array $row) use ($schema) {
            $schemaArray = $this->schemaFactory->create($schema);

            return $this->reflectionHydrator->hydrate(
                $this->arrayConverter->convert($row, $schemaArray),
                (new \ReflectionClass($schema))->newInstanceWithoutConstructor()
            );
        }, $data);
    }
}
