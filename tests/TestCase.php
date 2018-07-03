<?php
namespace Ma3oBblu\gii\generators\tests;

use yii\console\Application;

/**
 * Class TestCase
 * @package Ma3oBblu\gii\fixture\tests
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    protected function tearDown()
    {
        $this->destroyApplication();
        parent::tearDown();
    }

    protected function mockApplication()
    {
        new Application([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'runtimePath' => __DIR__ . '/runtime',
            'aliases' => [
                '@tests' => __DIR__,
            ],
        ]);
    }

    protected function destroyApplication()
    {
        \Yii::$app = null;
    }
}