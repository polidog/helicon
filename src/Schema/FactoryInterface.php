<?php

declare(strict_types=1);

namespace Polidog\Helicon\Schema;

interface FactoryInterface
{
    public function __invoke(string $schemaName): array;
}
