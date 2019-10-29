<?php

declare(strict_types=1);

namespace Polidog\Helicon\TypeCaster;

class NumberTypeCaster implements TypeCasterInterface
{
    public function convert($value, string $type)
    {
        if (\is_int($value) || \is_float($value)) {
            return $value;
        }

        if (!\is_string($value)) {
            throw new TypeCasterException('Unsupported type ');
        }

        if (preg_match('/^(\d+)$/', $value, $matches)) {
            return (int) $value;
        }

        return (float) $value;
    }

    public function supports(string $type): bool
    {
        return 'number' === $type;
    }
}
