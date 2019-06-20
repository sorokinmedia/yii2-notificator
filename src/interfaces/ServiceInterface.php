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
     * метод получения названия сервиса
     * @return string
     */
    public function getName(): string;

    /**
     * метод для единичной отправки уведомления
     * @param BaseOutbox $baseOutbox
     * @param string $class
     * @return bool
     */
    public function send(BaseOutbox $baseOutbox, string $class): bool;

    /**
     * метод для групповой отправки уведомлений
     * @param BaseOutbox $baseOutbox
     * @param string $class
     * @return bool
     */
    public function sendGroup(BaseOutbox $baseOutbox, string $class): bool;
    
    /**
     * Включена ли групповая рассылка через данный сервис
     * @return bool
     */
    public function isGroup(): bool;
}
