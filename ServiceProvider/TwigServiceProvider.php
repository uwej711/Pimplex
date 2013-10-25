<?php
namespace Pimplex\ServiceProvider;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Bridge\Twig\Extension\SecurityExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

class TwigServiceProvider
{
    public function register(\Pimple $container)
    {
        $container['twig.options'] = array();
        $container['twig.form.templates'] = array('form_div_layout.html.twig');
        $container['twig.path'] = array();
        $container['twig.templates'] = array();

        $container['twig'] = $container->share(function ($container) {
                $container['twig.options'] = array_replace(
                    array(
                        'charset'          => $container['charset'],
                        'debug'            => $container['debug'],
                        'strict_variables' => $container['debug'],
                    ), $container['twig.options']
                );

                $twig = new \Twig_Environment($container['twig.loader'], $container['twig.options']);
                $twig->addGlobal('container', $container);

                if ($container['debug']) {
                    $twig->addExtension(new \Twig_Extension_Debug());
                }

                if (class_exists('Symfony\Bridge\Twig\Extension\RoutingExtension')) {
                    if (isset($container['url_generator'])) {
                        $twig->addExtension(new RoutingExtension($container['url_generator']));
                    }

                    if (isset($container['translator'])) {
                        $twig->addExtension(new TranslationExtension($container['translator']));
                    }

                    if (isset($container['security'])) {
                        $twig->addExtension(new SecurityExtension($container['security']));
                    }

                    if (isset($container['form.factory'])) {
                        $container['twig.form.engine'] = $container->share(function ($container) {
                                return new TwigRendererEngine($container['twig.form.templates']);
                            });

                        $container['twig.form.renderer'] = $container->share(function ($container) {
                                return new TwigRenderer($container['twig.form.engine'], $container['form.csrf_provider']);
                            });

                        $twig->addExtension(new FormExtension($container['twig.form.renderer']));

                        // add loader for Symfony built-in form templates
                        $reflected = new \ReflectionClass('Symfony\Bridge\Twig\Extension\FormExtension');
                        $path = dirname($reflected->getFileName()).'/../Resources/views/Form';
                        $container['twig.loader']->addLoader(new \Twig_Loader_Filesystem($path));
                    }
                }

                return $twig;
            });

        $container['twig.loader.filesystem'] = $container->share(function ($container) {
                return new \Twig_Loader_Filesystem($container['twig.path']);
            });

        $container['twig.loader.array'] = $container->share(function ($container) {
                return new \Twig_Loader_Array($container['twig.templates']);
            });

        $container['twig.loader'] = $container->share(function ($container) {
                return new \Twig_Loader_Chain(array(
                    $container['twig.loader.array'],
                    $container['twig.loader.filesystem'],
                ));
            });
    }

}