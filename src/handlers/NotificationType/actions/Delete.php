<?php

namespace sorokinmedia\notificator\handlers\NotificationType\actions;

use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;

/**
 * Class Delete
 * @package sorokinmedia\notificator\handlers\NotificationType\actions
 */
class Delete extends AbstractAction
{
    /**
     * @return bool
     * @throws Throwable
     * @throws Exception
     * @throws StaleObjectException
     */
    public function execute(): bool
    {
        return $this->notification_type->deleteModel();
    }
}
