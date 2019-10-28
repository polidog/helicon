<?php

declare(strict_types=1);

namespace Polidog\Helicon\Converter;

use Polidog\Helicon\TypeCaster\Resolver;

class Converter implements ConverterInterface
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @param Resolver $resolver
     */
    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function convert(array $row, array $schemas): array
    {
        return array_map(function ($schema) use ($row) {
            $value = $row[$schema['property']];
            $converter = $this->resolver->resolve($schema['type']);
            $converter->convert($value, $schema['type']);
        }, $schemas);
    }
}
