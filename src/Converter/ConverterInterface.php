<?php

declare(strict_types=1);

namespace Polidog\Helicon\Converter;

interface ConverterInterface
{
    public function __invoke(array $row, array $schemas): array;
}
