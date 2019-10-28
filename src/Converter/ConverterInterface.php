<?php

declare(strict_types=1);

namespace Polidog\Helicon\Converter;

interface ConverterInterface
{
    public function convert(array $rows, array $schema): array;
}
