<?php

namespace sorokinmedia\notificator\handlers;

use sorokinmedia\notificator\BaseOutbox;
use sorokinmedia\notificator\interfaces\HandlerInterface;

/**
 * Class AbstractHandler
 * @package sorokinmedia\notificator\handlers
 */
abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @return array
     */
    abstract public function getMessageData(): array;

    /**
     * @return BaseOutbox[]
     */
    abstract public function execute(): array;
}
