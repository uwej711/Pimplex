<?php
namespace Pimplex;

class Container extends \Pimple
{
    protected $providers = array();

    public function __construct(array $values = array())
    {
        parent::__construct(array_merge(array('debug' => false, 'charset' => 'UTF-8', 'locale' => 'en'), $values));

    }

    public function register($provider, array $values = array())
    {
        $this->providers[] = $provider;

        $provider->register($this);

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        return $this;
    }
}
