<?php

namespace sorokinmedia\notificator\interfaces;

use yii\db\ActiveQuery;

/**
 * Interface OutboxInterface
 * @package sorokinmedia\notificator\interfaces
 */
interface OutboxInterface
{
    /**
     * отправка атубокса - реализация на проекте
     * @return bool
     */
    public function sendOutbox(): bool;

    /**
     * отправка группового аутбокса - реализация на проекта
     * @return bool
     */
    public function sendGroupOutbox(): bool;

    /**
     * получить пользователя получателя
     * @return ActiveQuery
     */
    public function getToUser(): ActiveQuery;

    /**
     * требуется ли мгновенная отправка или можно поставить в очередь
     * @return bool
     */
    public function isImmediate(): bool;
}
