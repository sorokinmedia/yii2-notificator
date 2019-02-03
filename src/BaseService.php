<?php

namespace sorokinmedia\notificator;

use sorokinmedia\notificator\interfaces\ServiceInterface;
use yii\base\Component;

/**
 * Class BaseService
 * @package sorokinmedia\notificator
 */
abstract class BaseService extends Component implements ServiceInterface
{
    //todo: вынести в конфиг компонента
    public $viewPath = '@common/components/notificator/views/';

    /**
     * @param BaseOutbox $baseOutbox
     * @return string
     */
    protected function _getAbsoluteViewPath(BaseOutbox $baseOutbox): string
    {
        return $this->viewPath . $this->getName() . '/' . $baseOutbox->view;
    }
}