<?php
namespace sorokinmedia\notificator;

use common\components\events\interfaces\HandlerInterface;
use common\components\events\interfaces\ServiceInterface;
use yii\base\Component;

/**
 * Class NotificatorCenter
 * @package common\components\events
 *
 * @property array $services Services configuration
 * @property ServiceInterface[] $_loadedServices
 */
class NotificatorCenter extends Component
{
    public $services;
    private $_loadedServices;

    /**
     * Services Initialization
     */
    public function init()
    {
        parent::init();
        foreach ($this->services as $name => $class) {
            $this->_loadedServices[$name] = new $class;
        }
    }

    /**
     * @param HandlerInterface $handler
     */
    public function send(HandlerInterface $handler)
    {
        $outboxes = $handler->execute();
        foreach ($this->_loadedServices as $service) {
            foreach ($outboxes as $baseOutbox) {
                $service->send($baseOutbox);
            }
        }
    }
}