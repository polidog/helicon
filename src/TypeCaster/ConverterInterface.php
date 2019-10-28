<?php

declare(strict_types=1);

namespace Polidog\Helicon\TypeCaster;

interface ConverterInterface
{
    /**
     * @param $value
     * @param string $type
     *
     * @return mixed
     */
    public function convert($value, string $type);

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;
}
