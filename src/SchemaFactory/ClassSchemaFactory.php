<?php

declare(strict_types=1);

namespace Polidog\Helicon\SchemaFactory;

use Zend\Code\Generator\DocBlock\Tag\VarTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Reflection\DocBlockReflection;

class ClassSchemaFactory
{
    /**
     * @param string $className
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function create(string $className): array
    {
        $refClass = new \ReflectionClass($className);
        $results = [];
        // TODO キャッシュとか入れたいしZend依存激しいので別クラスにしたい
        foreach ($refClass->getProperties() as $property) {
            $comment = $property->getDocComment();
            $commentReflection = new DocBlockReflection($comment);
            $generator = DocBlockGenerator::fromReflection($commentReflection);
            foreach ($generator->getTags() as $tag) {
                if ($tag instanceof VarTag) {
                    $results[$property->getName()] = [
                        'type' => $tag->getTypes()[0],
                    ]; // TODO エラー処理、どの型を優先するかを決める
                }
            }
        }

        return $results;
    }
}
