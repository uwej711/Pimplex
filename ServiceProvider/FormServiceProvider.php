<?php
namespace Pimplex\ServiceProvider;

use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension as FormValidatorExtension;

use Symfony\Component\Form\Forms;

class FormServiceProvider
{
    public function register(\Pimple $container)
    {
        if (!class_exists('Locale') && !class_exists('Symfony\Component\Locale\Stub\StubLocale')) {
            throw new \RuntimeException('You must either install the PHP intl extension or the Symfony Locale Component to use the Form extension.');
        }

        if (!class_exists('Locale')) {
            $r = new \ReflectionClass('Symfony\Component\Locale\Stub\StubLocale');
            $path = dirname(dirname($r->getFilename())).'/Resources/stubs';

            require_once $path.'/functions.php';
            require_once $path.'/Collator.php';
            require_once $path.'/IntlDateFormatter.php';
            require_once $path.'/Locale.php';
            require_once $path.'/NumberFormatter.php';
        }

        $container['form.secret'] = md5(__DIR__);

        $container['form.type.extensions'] = $container->share(function ($container) {
                return array();
            });

        $container['form.type.guessers'] = $container->share(function ($container) {
                return array();
            });

        $container['form.extensions'] = $container->share(function ($container) {
                $extensions = array(
                    new CsrfExtension($container['form.csrf_provider']),
                    new HttpFoundationExtension(),
                );

                if (isset($container['validator'])) {
                    $extensions[] = new FormValidatorExtension($container['validator']);

                    if (isset($container['translator'])) {
                        $r = new \ReflectionClass('Symfony\Component\Form\Form');
                        $container['translator']->addResource('xliff', dirname($r->getFilename()).'/Resources/translations/validators.'.$container['locale'].'.xlf', $container['locale'], 'validators');
                    }
                }

                return $extensions;
            });

        $container['form.factory'] = $container->share(function ($container) {
                return Forms::createFormFactoryBuilder()
                  ->addExtensions($container['form.extensions'])
                  ->addTypeExtensions($container['form.type.extensions'])
                  ->addTypeGuessers($container['form.type.guessers'])
                  ->getFormFactory()
                  ;
            });

        $container['form.csrf_provider'] = $container->share(function ($container) {
                if (isset($container['session'])) {
                    return new SessionCsrfProvider($container['session'], $container['form.secret']);
                }

                return new DefaultCsrfProvider($container['form.secret']);
            });
    }

}