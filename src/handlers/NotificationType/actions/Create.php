<?php

namespace sorokinmedia\notificator\handlers\NotificationType\actions;

use Throwable;
use yii\db\Exception;

/**
 * Class Create
 * @package sorokinmedia\notificator\handlers\NotificationType\actions
 */
class Create extends AbstractAction
{
    /**
     * @return bool
     * @throws Throwable
     * @throws Exception
     */
    public function execute(): bool
    {
        $this->notification_type->insertModel();
        return true;
    }
}
