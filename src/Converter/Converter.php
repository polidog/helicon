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

    public function __invoke(array $row, array $schemas): array
    {
        $results = [];
        foreach ($row as $property => $value) {
            $schema = $schemas[$property];
            $converter = $this->resolver->resolve($schema['type']);
            $results[$property] = $converter->convert($value, $schema['type']);
        }

        return $results;
    }
}
