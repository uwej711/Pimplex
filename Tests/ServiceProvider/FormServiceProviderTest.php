<?php
namespace Pimplex\Tests\ServiceProvider;

use Pimplex\ServiceProvider\FormServiceProvider;
use Pimplex\Tests\ContainerTest;

class FormServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new FormServiceProvider());
    }

    public function testForm()
    {
        $this->assertTrue(isset($this->container['form.factory']));
        $this->assertInstanceOf('Symfony\Component\Form\FormFactory', $this->container['form.factory']);
    }

}