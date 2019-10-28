<?php

declare(strict_types=1);

namespace Polidog\Helicon\Converter;

interface ConverterInterface
{
    public function convert(array $row, array $schemas): array;
}
