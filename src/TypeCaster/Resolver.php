<?php

declare(strict_types=1);

namespace Polidog\Helicon\TypeCaster;

class Resolver
{
    /**
     * @var ConverterInterface[]
     */
    private $converters = [];

    public function addConverter(ConverterInterface $converter): void
    {
        $this->converters[] = $converter;
    }

    public function resolve(string $type): ConverterInterface
    {
        foreach ($this->converters as $converter) {
            if ($converter->supports($type)) {
                return $converter;
            }
        }

        throw new \RuntimeException('converter not supported '.$type); // TODO custom exception.
    }
}
