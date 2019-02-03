<?php

namespace sorokinmedia\notificator\handlers\NotificationType\actions;

/**
 * Class Delete
 * @package sorokinmedia\notificator\handlers\NotificationType\actions
 */
class Delete extends AbstractAction
{
    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function execute(): bool
    {
        return $this->notification_type->deleteModel();
    }
}