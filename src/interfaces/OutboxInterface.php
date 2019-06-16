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
     * @return OutboxInterface
     */
    public static function create(): self;

    /**
     * @return bool
     */
    public function sendOutbox(): bool;

    /**
     * @return ActiveQuery
     */
    public function getToUser(): ActiveQuery;
}
