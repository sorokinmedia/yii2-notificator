<?php

namespace sorokinmedia\notificator\handlers\NotificationType\interfaces;

/**
 * Interface ActionExecutable
 * @package sorokinmedia\notificator\handlers\NotificationType\interfaces
 */
interface ActionExecutable
{
    /**
     * @return bool
     */
    public function execute(): bool;
}