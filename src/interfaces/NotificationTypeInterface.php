<?php

namespace sorokinmedia\notificator\interfaces;

use yii\db\ActiveQuery;

/**
 * Interface NotificationTypeInterface
 * @package sorokinmedia\notificator\interfaces
 */
interface NotificationTypeInterface
{
    /**
     * вернуть массив типов id=>name
     * @return array
     */
    public static function getTypesArray(): array;

    /**
     * найди все типы по роли
     * @param string $role
     * @return array
     */
    public static function findByRole(string $role): array;

    /**
     * передать данные из формы в сущность
     * @return void
     */
    public function getFromForm(): void;

    /**
     * добавление в БД
     * @return bool
     */
    public function insertModel(): bool;

    /**
     * операции после добавления в БД
     * @return bool
     */
    public function afterInsertModel(): bool;

    /**
     * обновление в БД
     * @return bool
     */
    public function updateModel(): bool;

    /**
     * операции при обновлении роли
     * @return bool
     */
    public function afterRoleUpdate(): bool;

    /**
     * удаление из БД
     * @return bool
     */
    public function deleteModel(): bool;

    /**
     * операции перед удалением из БД
     * @return bool
     */
    public function beforeDeleteModel(): bool;

    /**
     * получить конфиги пользователя для данного типа уведомлений
     * @return ActiveQuery
     */
    public function getNotificationConfigs(): ActiveQuery;
}
