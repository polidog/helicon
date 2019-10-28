<?php

declare(strict_types=1);

namespace Polidog\Helicon\Schema;

use Psr\SimpleCache\CacheInterface;
use Zend\Code\Generator\DocBlock\Tag\VarTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Reflection\DocBlockReflection;

class Factory
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
     * @param string $className
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function create(string $className): array
    {
        $cached = $this->readCache($className);
        if (null !== $cached) {
            return $cached;
        }

        $refClass = new \ReflectionClass($className);
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

        $this->saveCache($className, $schema);

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
