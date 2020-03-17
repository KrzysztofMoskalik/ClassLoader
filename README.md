Class Loader
===

This is a simple tool to get class object from given directory.

Usage
---
Basic usage:
```php
$loader = new ClassLoader();
$objects = $loader->loadClassesFromDirectory(
    __DIR__ . '/src/'
);
```
This will return objects from all classes that exists in `./src` directory.

If your classes needed some `_construct` arguments, you can pass them as second argument.

Third argument is used for filtering returned objects base on `instanceof` function,
so you can only get children of given class or those implementing specified interface.