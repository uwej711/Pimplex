<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Container\Tests\ServiceProvider;

use Valiton\Container\ServiceProvider\TranslationServiceProvider;
use Valiton\Container\Tests\ContainerTest;

class TranslationServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new TranslationServiceProvider());

        $this->assertTrue(isset($this->container['translator']));
        $this->assertInstanceOf('Symfony\Component\Translation\Translator', $this->container['translator']);
    }

}