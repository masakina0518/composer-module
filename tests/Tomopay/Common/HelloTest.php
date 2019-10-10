<?php

namespace Tomopay\Tests\Common;
use Tomopay\Common\Hello;

/**
 * サンプルクラステスト
 *
 * @author masaki.naito
 */
class HelloTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 挨拶文言のテスト
     *
     * @return void
     */
    public function testSayHello() {
        $expectedGreeting = "Hello world1.0.1";
        $actualGreeting = Hello::sayHello();
        $this->assertEquals($expectedGreeting, $actualGreeting);
    }
}
