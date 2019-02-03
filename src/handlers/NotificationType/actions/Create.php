<?php

namespace sorokinmedia\notificator\handlers\NotificationType\actions;

/**
 * Class Create
 * @package sorokinmedia\notificator\handlers\NotificationType\actions
 */
class Create extends AbstractAction
{
    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function execute(): bool
    {
        $this->notification_type->insertModel();
        return true;
    }
}