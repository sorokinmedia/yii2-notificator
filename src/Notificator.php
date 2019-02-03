<?php

namespace sorokinmedia\notificator;

use sorokinmedia\notificator\interfaces\{HandlerInterface, ServiceInterface};
use yii\base\Component;

/**
 * Class NotificatorCenter
 * @package sorokinmedia\notificator
 *
 * @property array $services Services configuration
 * @property ServiceInterface[] $_loadedServices
 */
class Notificator extends Component
{
    public $services;
    private $_loadedServices;

    /**
     * Services Initialization
     * @return void
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
     * @return void
     */
    public function send(HandlerInterface $handler)
    {
        $outboxes = $handler->execute();
        foreach ($this->_loadedServices as $service) {
            /** @var ServiceInterface $service */
            foreach ($outboxes as $baseOutbox) {
                $service->send($baseOutbox);
            }
        }
    }
}