<?php
namespace sorokinmedia\notificator;

use common\components\events\interfaces\ServiceInterface;
use yii\base\Component;

/**
 * Class BaseService
 * @package sorokinmedia\notificator
 */
abstract class BaseService extends Component implements ServiceInterface
{
    public $viewPath = '@common/components/events/views/';

    /**
     * @param BaseOutbox $baseOutbox
     *
     * @return string
     */
    protected function _getAbsoluteViewPath(BaseOutbox $baseOutbox)
    {
        return $this->viewPath . $this->getName() . '/' . $baseOutbox->view;
    }
}