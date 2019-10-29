<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Polidog\Helicon\Converter\Converter;
use Polidog\Helicon\Converter\ConverterInterface;
use Polidog\Helicon\Schema\FactoryInterface;
use Polidog\Helicon\Schema\ObjectSchemaFactory;
use Zend\Hydrator\ReflectionHydrator;

class ObjectMapper implements MapperInterface
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * @var ObjectSchemaFactory
     */
    private $schemaFactory;

    /**
     * @var ReflectionHydrator
     */
    private $reflectionHydrator;

    /**
     * @param ConverterInterface $converter
     * @param FactoryInterface   $schemaFactory
     * @param ReflectionHydrator $reflectionHydrator
     */
    public function __construct(ConverterInterface $converter, FactoryInterface $schemaFactory, ReflectionHydrator $reflectionHydrator)
    {
        $this->converter = $converter;
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
            return $this->reflectionHydrator->hydrate(
                ($this->converter)($row, ($this->schemaFactory)($schema)),
                (new \ReflectionClass($schema))->newInstanceWithoutConstructor()
            );
        }, $data);
    }
}
