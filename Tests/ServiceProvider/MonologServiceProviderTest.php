<?php

namespace Pimplex\Tests\ServiceProvider;

use Pimplex\ServiceProvider\MonologServiceProvider;
use Pimplex\Tests\ContainerTest;

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