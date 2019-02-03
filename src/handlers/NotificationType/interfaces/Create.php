<?php

namespace sorokinmedia\notificator\handlers\NotificationType\interfaces;

/**
 * Interface Create
 * @package sorokinmedia\notificator\handlers\NotificationType\interfaces
 */
interface Create
{
    /**
     * @return bool
     */
    public function create(): bool;
}