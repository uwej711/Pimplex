<?php
namespace Pimplex\ServiceProvider;

use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

class TranslationServiceProvider
{
    public function register(\Pimple $container)
    {
        $container['translator'] = $container->share(function ($container) {
                $translator = new Translator($container['locale'], $container['translator.message_selector']);

                // Handle deprecated 'locale_fallback'
                if (isset($container['locale_fallback'])) {
                    $container['locale_fallbacks'] = (array) $container['locale_fallback'];
                }

                $translator->setFallbackLocales($container['locale_fallbacks']);

                $translator->addLoader('array', new ArrayLoader());
                $translator->addLoader('xliff', new XliffFileLoader());

                foreach ($container['translator.domains'] as $domain => $data) {
                    foreach ($data as $locale => $messages) {
                        $translator->addResource('array', $messages, $locale, $domain);
                    }
                }

                return $translator;
            });

        $container['translator.message_selector'] = $container->share(function () {
                return new MessageSelector();
            });

        $container['translator.domains'] = array();

        $container['locale_fallbacks'] = array(
            'en'
        );
    }
}
