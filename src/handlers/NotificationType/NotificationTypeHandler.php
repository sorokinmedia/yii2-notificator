<?php

namespace sorokinmedia\notificator\handlers\NotificationType;

use sorokinmedia\notificator\entities\NotificationType\AbstractNotificationType;
use sorokinmedia\notificator\handlers\NotificationType\interfaces\{Create, Delete, Update};


/**
 * Class NotificationTypeHandler
 * @package sorokinmedia\notificator\handlers\NotificationType
 *
 * @property AbstractNotificationType $notification_type
 */
class NotificationTypeHandler implements Create, Update, Delete
{
    public $notification_type;

    /**
     * NotificationTypeHandler constructor.
     * @param AbstractNotificationType $notificationType
     */
    public function __construct(AbstractNotificationType $notificationType)
    {
        $this->notification_type = $notificationType;
        return $this;
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function create(): bool
    {
        return (new actions\Create($this->notification_type))->execute();
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function update(): bool
    {
        return (new actions\Update($this->notification_type))->execute();
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function delete(): bool
    {
        return (new actions\Delete($this->notification_type))->execute();
    }
}