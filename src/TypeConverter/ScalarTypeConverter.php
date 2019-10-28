<?php

declare(strict_types=1);

namespace Polidog\Helicon\TypeConverter;

class ScalarTypeConverter implements ConverterInterface
{
    private const SUPPORTED_TYPES = [
        'boolean',
        'bool',
        'integer',
        'int',
        'string',
        'float',
        'double',
    ];

    /**
     * @param $value
     * @param string $type
     *
     * @return bool|int|string
     */
    public function convert($value, string $type)
    {
        settype($value, $type);

        return $value;
    }

    public function supports(string $type): bool
    {
        return \in_array($type, self::SUPPORTED_TYPES, true);
    }
}
