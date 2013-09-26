<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Container\Tests\ServiceProvider;

use Valiton\Container\ServiceProvider\ValidatorServiceProvider;
use Valiton\Container\Tests\ContainerTest;

class ValidatorServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new ValidatorServiceProvider());
    }

    public function testValidator()
    {
        $this->assertTrue(isset($this->container['validator']));
        $this->assertInstanceOf('Symfony\Component\Validator\Validator', $this->container['validator']);
    }

}