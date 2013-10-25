Pimple with ServiceProviders for several Symfony 2 components
=============================================================

This library add ServiceProviders to Pimple to use some Symfony 2 components.

Inspired by Silex but for use cases where you don't need the full (micro) framework,
e.g. for adding Symfony Components to an existing PHP application.

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
