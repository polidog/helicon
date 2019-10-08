<?php

declare(strict_types=1);

namespace Polidog\Helicon;

interface Hydrator
{
    public function hydrate(array $data, string $schema): array;

    public function extract(array $objectArray): array;
}
