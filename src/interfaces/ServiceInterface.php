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
     * @return string
     */
    public function getName(): string;

    /**
     * @param BaseOutbox $baseOutbox
     * @return bool
     */
    public function send(BaseOutbox $baseOutbox): bool;
}
