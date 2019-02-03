<?php

namespace sorokinmedia\notificator\handlers\NotificationType\actions;

use sorokinmedia\notificator\entities\NotificationType\AbstractNotificationType;
use sorokinmedia\notificator\handlers\NotificationType\interfaces\ActionExecutable;

/**
 * Class AbstractAction
 * @package sorokinmedia\notificator\handlers\NotificationType\actions
 *
 * @property AbstractNotificationType $notification_type
 */
abstract class AbstractAction implements ActionExecutable
{
    protected $notification_type;

    /**
     * AbstractAction constructor.
     * @param AbstractNotificationType $notificationType
     */
    public function __construct(AbstractNotificationType $notificationType)
    {
        $this->notification_type = $notificationType;
        return $this;
    }
}