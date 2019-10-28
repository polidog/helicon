<?php

declare(strict_types=1);

namespace Polidog\Helicon\Converter;

use Polidog\Helicon\TypeConverter\Resolver;

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

    public function convert(array $rows, array $schema): array
    {
        foreach ($rows as $key => $value) {
            $converter = $this->resolver->resolve($schema[$key]['type']);
            $rows[$key] = $converter->convert($value, $schema[$key]['type']);
        }

        return $rows;
    }
}
