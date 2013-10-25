<?php
namespace Pimplex\Tests;

use Pimplex\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Container */
    protected $container;

    protected function setUp()
    {
        $this->container = new Container();
    }

    public function testParameter()
    {
        $this->container['foo'] = array('bar' => 'baz');
        $foo = $this->container['foo'];

        $this->assertSame('baz', $foo['bar']);
    }

    public function testOverwriteParameters()
    {
        $container = new Container(array('locale' => 'de'));

        $this->assertSame('de', $container['locale']);
    }

}