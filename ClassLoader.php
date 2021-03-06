<?php

namespace KrzysztofMoskalik\ClassLoader;

use Gnugat\NomoSpaco\File\FileRepository;
use Gnugat\NomoSpaco\FqcnRepository;
use Gnugat\NomoSpaco\Token\ParserFactory;

class ClassLoader {
    /**
     * @param string $directory
     * @param array $arguments
     *
     * @param string|null $parent
     *
     * @return object[]
     * @throws \Exception
     */
    public function loadClassesFromDirectory (string $directory, array $arguments, string $parent = null): array
    {
        $directory =  substr($directory, -1) === DIRECTORY_SEPARATOR ? $directory : $directory . DIRECTORY_SEPARATOR;

        $fqcnRepository = new FqcnRepository(
            new FileRepository(),
            new ParserFactory()
        );

        $classes = $fqcnRepository->findIn($directory);

        $objects = [];

        foreach ($classes as $class) {
            $reflectionClass = new \ReflectionClass($class);
            if ($reflectionClass->isAbstract() || $reflectionClass->isInterface()) {
                continue;
            }
            
            $object = new $class(...$arguments);
            if ($parent !== null && !($object instanceof $parent)) {
                continue;
            }
            if ($object instanceof \Stringable) {
                $objects[(string) $object] = $object;
            } else {
                $objects[] = $object;
            }
        }

        return $objects;
    }
}
