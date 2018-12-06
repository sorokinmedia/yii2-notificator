<?php
namespace sorokinmedia\notificator\interfaces;

use sorokinmedia\notificator\BaseOutbox;

/**
 * Interface HandlerInterface
 * @package sorokinmedia\notificator\interfaces
 */
interface HandlerInterface
{
    /**
     * @return BaseOutbox[]
     */
    public function execute();

    /**
     * @return mixed
     */
    public function getMessageData();
}