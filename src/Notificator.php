<?php

namespace sorokinmedia\notificator;

use sorokinmedia\notificator\interfaces\{HandlerInterface, OutboxInterface, ServiceInterface};
use yii\base\Component;

/**
 * Class NotificatorCenter
 * @package sorokinmedia\notificator
 *
 * @property array $services Services configuration
 * @property string $viewPath Path to views folder
 * @property ServiceInterface[] $_loadedServices
 * @property OutboxInterface[] $_loadedOutboxes
 */
class Notificator extends Component
{
    public $services;
    public $outboxes;
    public $viewPath = '@common/components/notificator/views/';
    private $_loadedServices;
    private $_loadedOutboxes;

    /**
     * Services Initialization
     * @return void
     */
    public function init(): void
    {
        parent::init();
        foreach ($this->services as $name => $class) {
            $this->_loadedServices[$name] = new $class([
                'viewPath' => $this->viewPath
            ]);
        }
        foreach ($this->outboxes as $name => $class) {
            $this->_loadedOutboxes[$name] = new $class();
        }
    }

    /**
     * @param HandlerInterface $handler
     * @return void
     */
    public function send(HandlerInterface $handler): void
    {
        $outboxes = $handler->execute();
        foreach ($this->_loadedServices as $service) {
            /** @var ServiceInterface $service */
            foreach ($outboxes as $baseOutbox) {
                $service->send($baseOutbox, $this->_loadedOutboxes[$service->getName()]);
            }
        }
    }

    /**
     * @param HandlerInterface $handler
     */
    public function sendGroup(HandlerInterface $handler): void
    {
        $outboxes = $handler->execute();
        foreach ($this->_loadedServices as $service){
            /** @var ServiceInterface $service */
            if ($service->isGroup() === true){
                foreach ($outboxes as $baseOutbox){
                    $service->sendGroup($baseOutbox);
                }
            }
        }
    }
}
