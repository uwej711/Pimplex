<?php
namespace Pimplex\Tests\ServiceProvider;

use Pimplex\ServiceProvider\ValidatorServiceProvider;
use Pimplex\Tests\ContainerTest;

class ValidatorServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new ValidatorServiceProvider());
    }

    public function testProperClassIsProvided()
    {
        $this->assertTrue(isset($this->container['validator']));
        $this->assertInstanceOf('Symfony\Component\Validator\Validator', $this->container['validator']);
    }

}