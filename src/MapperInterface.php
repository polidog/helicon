<?php

declare(strict_types=1);

namespace Polidog\Helicon;

interface MapperInterface
{
    public function __invoke(array $data, string $schema): array;
}
