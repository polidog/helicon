<?php

declare(strict_types=1);

namespace Polidog\Helicon\Schema;

use Psr\SimpleCache\CacheInterface;
use Zend\Code\Generator\DocBlock\Tag\VarTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Reflection\DocBlockReflection;

class ObjectSchemaFactory implements FactoryInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache = null)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $schemaName
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function create(string $schemaName): array
    {
        $cached = $this->readCache($schemaName);
        if (null !== $cached) {
            return $cached;
        }

        $refClass = new \ReflectionClass($schemaName);
        $schema = [];
        foreach ($refClass->getProperties() as $property) {
            $comment = $property->getDocComment();
            $commentReflection = new DocBlockReflection($comment);
            $generator = DocBlockGenerator::fromReflection($commentReflection);
            foreach ($generator->getTags() as $tag) {
                if ($tag instanceof VarTag) {
                    $schema[$property->getName()] = [
                        'type' => $tag->getTypes()[0],
                    ];
                }
            }
        }

        $this->saveCache($schemaName, $schema);

        return $schema;
    }

    private function readCache(string $className): ?array
    {
        if (null === $this->cache) {
            return null;
        }

        return $this->cache->get($this->cacheKey($className));
    }

    private function saveCache(string $className, array $schema)
    {
        if (null !== $this->cache) {
            $this->cache->set($this->cacheKey($className), $schema);
        }
    }

    private function cacheKey(string $className)
    {
        return 'helicon_'.sha1($className);
    }
}
