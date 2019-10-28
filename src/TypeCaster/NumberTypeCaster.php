<?php

namespace Polidog\Helicon\TypeCaster;


class NumberTypeCaster implements TypeCasterInterface
{
    public function convert($value, string $type)
    {
        if (preg_match('/^(\d+)$/', $value, $matches)) {
            return (int)$value;
        }
        return (float)$value;
    }

    public function supports(string $type): bool
    {
        return 'number' === $type;
    }

}
