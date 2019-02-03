<?php

namespace sorokinmedia\notificator\handlers\NotificationType\actions;

/**
 * Class Update
 * @package sorokinmedia\notificator\handlers\NotificationType\actions
 */
class Update extends AbstractAction
{
    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function execute(): bool
    {
        $this->notification_type->updateModel();
        return true;
    }
}