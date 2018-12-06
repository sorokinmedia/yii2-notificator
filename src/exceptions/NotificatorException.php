<?php
namespace sorokinmedia\notificator\exceptions;

use yii\base\Exception;

/**
 * Class NotificatorException
 * @package sorokinmedia\notificator\exceptions
 */
class NotificatorException extends Exception
{
    /**
     * @param int $code
     */
    public function construct(int $code = 0)
    {
        if (array_key_exists($code, self::$messages)) {
            parent::__construct(self::$messages[$code], $code);
        }

        parent::__construct(\Yii::t('app', 'Ошибка центра нотификаций'), $code);
    }

    static $messages = [
    ];
}