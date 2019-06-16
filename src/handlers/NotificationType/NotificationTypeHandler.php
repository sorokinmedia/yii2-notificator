<?php

namespace sorokinmedia\notificator\handlers\NotificationType;

use sorokinmedia\notificator\entities\NotificationType\AbstractNotificationType;
use sorokinmedia\notificator\handlers\NotificationType\interfaces\{Create, Delete, Update};
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;


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
     * @throws Throwable
     * @throws Exception
     */
    public function create(): bool
    {
        return (new actions\Create($this->notification_type))->execute();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        return (new actions\Update($this->notification_type))->execute();
    }

    /**
     * @return bool
     * @throws Throwable
     * @throws Exception
     * @throws StaleObjectException
     */
    public function delete(): bool
    {
        return (new actions\Delete($this->notification_type))->execute();
    }
}
