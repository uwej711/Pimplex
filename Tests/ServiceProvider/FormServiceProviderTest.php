<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Container\Tests\ServiceProvider;

use Valiton\Container\ServiceProvider\FormServiceProvider;
use Valiton\Container\Tests\ContainerTest;

class FormServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new FormServiceProvider());

        $this->assertTrue(isset($this->container['form.factory']));
        $this->assertInstanceOf('Symfony\Component\Form\FormFactory', $this->container['form.factory']);
    }

}