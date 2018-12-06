<?php
namespace sorokinmedia\notificator;

//todo: user identity
use yii\base\BaseObject;
use yii\web\User;

/**
 * Class BaseOutbox
 * @package sorokinmedia\notificator
 *
 * @property User|array $recipients
 * @property string $view
 * @property array $messageData
 * @property int $toId
 */
class BaseOutbox extends BaseObject
{
    public $recipients;
    public $view;
    public $messageData;
    public $toId;

    /**
     * BaseOutbox constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        if ($this->recipients instanceof Users) {
            $this->toId = $this->recipients->id;
        }
    }
}
