<?php

namespace sorokinmedia\notificator\handlers\NotificationType\interfaces;

/**
 * Interface Update
 * @package sorokinmedia\notificator\handlers\NotificationType\interfaces
 */
interface Update
{
    /**
     * @return bool
     */
    public function update(): bool;
}