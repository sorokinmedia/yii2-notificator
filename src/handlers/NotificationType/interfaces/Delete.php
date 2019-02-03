<?php

namespace sorokinmedia\notificator\handlers\NotificationType\interfaces;

/**
 * Interface Delete
 * @package sorokinmedia\notificator\handlers\NotificationType\interfaces
 */
interface Delete
{
    /**
     * @return bool
     */
    public function delete(): bool;
}