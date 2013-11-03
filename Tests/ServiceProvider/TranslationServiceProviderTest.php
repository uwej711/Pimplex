<?php
namespace Pimplex\Tests\ServiceProvider;

use Pimplex\ServiceProvider\TranslationServiceProvider;
use Pimplex\Tests\ContainerTest;

class TranslationServiceProviderTest extends ContainerTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->register(new TranslationServiceProvider());
    }

    public function testProperClassIsProvided()
    {
        $this->assertTrue(isset($this->container['translator']));
        $this->assertInstanceOf('Symfony\Component\Translation\Translator', $this->container['translator']);
    }

}