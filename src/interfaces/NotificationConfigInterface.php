<?php

namespace sorokinmedia\notificator\interfaces;

use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * Interface NotificationConfigInterface
 * @package sorokinmedia\notificator\interfaces
 */
interface NotificationConfigInterface
{
    /**
     * статический конструктор
     * @param IdentityInterface $user
     * @param NotificationTypeInterface $notificationType
     * @return NotificationConfigInterface
     */
    public static function create(IdentityInterface $user, NotificationTypeInterface $notificationType): self;

    /**
     * получить тип уведомления
     * @return ActiveQuery
     */
    public function getType(): ActiveQuery;

    /**
     * получить пользователя
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery;

    /**
     * проверки перед сохранением конфига
     * @return void
     */
    public function checkBeforeConfigSave(): void;

    /**
     * обновление конфига
     * @param int $in_site
     * @param int $email
     * @param int $sms
     * @param int $telegram
     * @return bool
     */
    public function updateModel(int $in_site, int $email, int $sms, int $telegram): bool;
}
