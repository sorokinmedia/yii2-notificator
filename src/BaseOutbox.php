<?php

namespace sorokinmedia\notificator;

use sorokinmedia\notificator\interfaces\RecipientInterface;
use yii\base\BaseObject;

/**
 * Class BaseOutbox
 * @package common\components\notificator
 *
 * @property RecipientInterface|array $recipients
 * @property string $view
 * @property array $messageData
 * @property int $toId
 * @property int $type_id
 */
class BaseOutbox extends BaseObject
{
    public $recipients;
    public $view;
    public $messageData;
    public $toId;
    public $type_id;

    /**
     * BaseOutbox constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if ($this->recipients instanceof RecipientInterface) {
            $this->toId = $this->recipients->id;
        }
    }
}
