<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Polidog\Helicon\Converter\Converter;
use Polidog\Helicon\Schema\Factory;
use Zend\Hydrator\ReflectionHydrator;

class ObjectMapper implements MapperInterface
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * @var Factory
     */
    private $schemaFactory;

    /**
     * @var ReflectionHydrator
     */
    private $reflectionHydrator;

    /**
     * @param Converter          $converter
     * @param Factory            $schemaFactory
     * @param ReflectionHydrator $reflectionHydrator
     */
    public function __construct(Converter $converter, Factory $schemaFactory, ReflectionHydrator $reflectionHydrator)
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
            $schemaArray = $this->schemaFactory->create($schema);

            return $this->reflectionHydrator->hydrate(
                $this->converter->convert($row, $schemaArray),
                (new \ReflectionClass($schema))->newInstanceWithoutConstructor()
            );
        }, $data);
    }
}
