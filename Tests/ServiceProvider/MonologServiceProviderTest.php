<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Container\Tests\ServiceProvider;

use Valiton\Container\ServiceProvider\MonologServiceProvider;
use Valiton\Container\Tests\ContainerTest;

class MonologServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new MonologServiceProvider(), array('monolog.logfile' => 'debug.log'));
    }

    public function testMonolog()
    {
        $this->assertTrue(isset($this->container['logger']));
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $this->container['logger']);
    }

}