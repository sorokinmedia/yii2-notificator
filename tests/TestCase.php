<?php

namespace Ma3oBblu\gii\generators\tests;

use Yii;
use yii\base\InvalidConfigException;
use yii\console\Application;

/**
 * Class TestCase
 * @package Ma3oBblu\gii\fixture\tests
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplication();
    }

    /**
     * @throws InvalidConfigException
     */
    protected function mockApplication(): void
    {
        new Application([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'runtimePath' => __DIR__ . '/runtime',
            'aliases' => [
                '@tests' => __DIR__,
            ],
            'components' => [
                'i18n' => [
                    'translations' => [
                        'app*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                            //'basePath' => '@app/messages',
                            //'sourceLanguage' => 'en-US',
                            'fileMap' => [
                                'app' => 'app.php',
                                'app/error' => 'error.php',
                            ],
                        ],
                    ],
                ],
            ]
        ]);
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        $this->destroyApplication();
        parent::tearDown();
    }

    /**
     *
     */
    protected function destroyApplication(): void
    {
        Yii::$app = null;
    }
}
