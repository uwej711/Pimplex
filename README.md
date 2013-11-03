ServiceProviders for Pimple for Symfony 2 components
====================================================

This library contains ServiceProviders for Pimple to use Symfony 2 components.

The code for the providers was taken from Silex and modified to work with plain Pimple
for use cases where you don't need the full (micro) framework,
e.g. for adding Symfony Components to an existing PHP application. See the LICENSE file.

Usage:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

$container = new Pimplex\Container();
$container->register(new Pimplex\ServiceProvider\TwigServiceProvider());

container['twig.path'] = 'your-template-path';

echo $container['twig']->render('hello.twig', array('name' => 'World');

```

or if you use plain Pimple

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

$container = new \Pimple();
$twigServiceProvider = new Pimplex\ServiceProvider\TwigServiceProvider();
$twigServiceProvider->register($container);

container['twig.path'] = 'your-template-path';

echo $container['twig']->render('hello.twig', array('name' => 'World');

```
