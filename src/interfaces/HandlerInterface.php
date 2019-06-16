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
     * выполнить хендлер
     * вернет набор аутбоксов для отправки
     * @return BaseOutbox[]
     */
    public function execute(): array;

    /**
     * получить данные необходимые в хендлере
     * @return array
     */
    public function getMessageData(): array;
}
