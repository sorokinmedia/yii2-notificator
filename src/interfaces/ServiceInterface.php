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

    /**
     * @param BaseOutbox $baseOutbox
     * @param string $accumulated_text
     * @return bool
     */
    public function sendGroup(BaseOutbox $baseOutbox, string $accumulated_text): bool;
    
    /**
     * Включена ли групповая рассылка через данный сервис
     * @return bool
     */
    public function isGroup(): bool;
}
