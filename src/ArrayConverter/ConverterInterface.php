<?php

declare(strict_types=1);

namespace Polidog\Helicon\ArrayConverter;

interface ConverterInterface
{
    public function convert(array $rows, array $schema): array;
}
