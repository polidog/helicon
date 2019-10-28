<?php

declare(strict_types=1);

namespace Polidog\Helicon\Schema;

class JsonSchemaFileFactory implements FactoryInterface
{
    public function create(string $schemaName): array
    {
        if (false === file_exists($schemaName)) {
            throw new \RuntimeException('json schema not found. name = '.$schemaName);
        }

        $jsonSchema = json_decode(file_get_contents($schemaName), true);
        $schemas = [];
        foreach ($jsonSchema['properties'] as $property => $values) {
            $schemas[$property] = [
                'type' => $values['type'],
            ];
        }

        return $schemas;
    }
}
