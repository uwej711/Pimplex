<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Container\Tests\ServiceProvider;

use Valiton\Container\ServiceProvider\TwigServicePRovider;
use Valiton\Container\Tests\ContainerTest;

class TwigServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new TwigServiceProvider());

        $this->assertTrue(isset($this->container['twig']));
        $this->assertInstanceOf('\Twig_Environment', $this->container['twig']);
    }

}