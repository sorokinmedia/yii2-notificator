<?php

namespace sorokinmedia\notificator\handlers\NotificationType\actions;

use yii\db\Exception;

/**
 * Class Update
 * @package sorokinmedia\notificator\handlers\NotificationType\actions
 */
class Update extends AbstractAction
{
    /**
     * @return bool
     * @throws Exception
     */
    public function execute(): bool
    {
        $this->notification_type->updateModel();
        return true;
    }
}
