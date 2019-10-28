<?php

namespace Polidog\Helicon\Schema;


interface FactoryInterface
{
    public function create(string $schemaName): array;
}
