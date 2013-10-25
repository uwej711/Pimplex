<?php
namespace Pimplex\ServiceProvider;

use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\DefaultTranslator;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator;

class ValidatorServiceProvider
{
    public function register(\Pimple $container)
    {
        $container['validator'] = $container->share(
            function ($container)
            {
                $r = new \ReflectionClass('Symfony\Component\Validator\Validator');

                if (isset($container['translator']))
                {
                    $container['translator']->addResource(
                        'xliff',
                      dirname(
                          $r->getFilename()
                      ) . '/Resources/translations/validators.' . $container['locale'] . '.xlf',
                        $container['locale'],
                        'validators'
                    );
                }

                return new Validator(
                    $container['validator.mapping.class_metadata_factory'],
                    $container['validator.validator_factory'],
                    isset($container['translator']) ? $container['translator'] : new DefaultTranslator()
                );
            }
        );

        $container['validator.mapping.class_metadata_factory'] = $container->share(
            function ($container)
            {
                return new ClassMetadataFactory(new StaticMethodLoader());
            }
        );

        $container['validator.validator_factory'] = $container->share(
            function () use ($container)
            {
                $validators = isset($container['validator.validator_service_ids']) ? $container['validator.validator_service_ids'] : array();

                return new ConstraintValidatorFactory($container, $validators);
            }
        );

    }

}