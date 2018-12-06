<?php
namespace sorokinmedia\notificator\interfaces;

use sorokinmedia\notificator\BaseOutbox;

/**
 * Interface ServiceInterface
 * @package sorokinmedia\notificator\interfaces
 */
interface ServiceInterface
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param BaseOutbox $baseOutbox
     * @return mixed
     */
    public function send(BaseOutbox $baseOutbox);
}