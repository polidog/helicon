<?php

declare(strict_types=1);

namespace Polidog\Helicon\TypeCaster;

class Resolver
{
    /**
     * @var TypeCasterInterface[]
     */
    private $converters = [];

    public function addConverter(TypeCasterInterface $converter): void
    {
        $this->converters[] = $converter;
    }

    public function resolve(string $type): TypeCasterInterface
    {
        foreach ($this->converters as $converter) {
            if ($converter->supports($type)) {
                return $converter;
            }
        }

        throw new TypeCasterException('converter not supported '.$type); // TODO custom exception.
    }
}
