<?php

namespace sorokinmedia\notificator;

use sorokinmedia\notificator\interfaces\ServiceInterface;
use yii\base\Component;

/**
 * Class BaseService
 * @package sorokinmedia\notificator
 *
 * @property string $viewPath
 */
abstract class BaseService extends Component implements ServiceInterface
{
    public $viewPath;

    /**
     * @param BaseOutbox $baseOutbox
     * @return string
     */
    protected function _getAbsoluteViewPath(BaseOutbox $baseOutbox): string
    {
        return $this->viewPath . $this->getName() . '/' . $baseOutbox->view;
    }
}