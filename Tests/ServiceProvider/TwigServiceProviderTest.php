<?php

namespace Pimplex\Tests\ServiceProvider;

use Pimplex\ServiceProvider\TwigServiceProvider;
use Pimplex\Tests\ContainerTest;

class TwigServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new TwigServiceProvider());
    }

    public function testTwig()
    {
        $this->assertTrue(isset($this->container['twig']));
        $this->assertInstanceOf('\Twig_Environment', $this->container['twig']);
    }

    public function testRender()
    {
        $this->container['twig.path'] = __DIR__.'/../Resources';
        $this->assertSame('Hello World!', $this->container['twig']->render('template.twig', array('name' => 'World')));
    }

}