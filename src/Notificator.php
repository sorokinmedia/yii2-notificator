<?php

namespace sorokinmedia\notificator;

use sorokinmedia\notificator\interfaces\{HandlerInterface, ServiceInterface};
use yii\base\Component;

/**
 * Class NotificatorCenter
 * @package sorokinmedia\notificator
 *
 * @property array $services Services configuration
 * @property string $viewPath Path to views folder
 * @property ServiceInterface[] $_loadedServices
 */
class Notificator extends Component
{
    public $services;
    public $viewPath = '@common/components/notificator/views/';
    private $_loadedServices;

    /**
     * Services Initialization
     * @return void
     */
    public function init()
    {
        parent::init();
        foreach ($this->services as $name => $class) {
            $this->_loadedServices[$name] = new $class([
                'viewPath' => $this->viewPath
            ]);
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