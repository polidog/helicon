<?php

declare(strict_types=1);

namespace Polidog\Helicon;

interface HydratorInterface
{
    public function hydrate(array $data, string $class): array;

    public function extract(array $objectArray): array;
}
