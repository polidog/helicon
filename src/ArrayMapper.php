<?php

declare(strict_types=1);

namespace Polidog\Helicon;

use Polidog\Helicon\Converter\Converter;
use Polidog\Helicon\Schema\FactoryInterface;
use Polidog\Helicon\Schema\ObjectSchemaFactory;

class ArrayMapper implements MapperInterface
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
     * @param Converter           $converter
     * @param FactoryInterface $schemaFactory
     */
    public function __construct(Converter $converter, FactoryInterface $schemaFactory)
    {
        $this->converter = $converter;
        $this->schemaFactory = $schemaFactory;
    }

    public function __invoke(array $data, string $schema): array
    {
        return array_map(function (array $row) use ($schema) {
            $schemaArray = $this->schemaFactory->create($schema);

            return $this->converter->convert($row, $schemaArray);
        }, $data);
    }
}
