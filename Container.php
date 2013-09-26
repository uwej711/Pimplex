<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Container;

class Container extends \Pimple
{
    protected $providers = array();

    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $this['debug'] = false;
        $this['charset'] = 'UTF-8';
        $this['locale'] = 'en';
    }


    public function register(ServiceProviderInterface $provider, array $values = array())
    {
        $this->providers[] = $provider;

        $provider->register($this);

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        return $this;
    }
}
