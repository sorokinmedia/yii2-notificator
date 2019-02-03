<?php

namespace sorokinmedia\notificator\services;

use sorokinmedia\notificator\{BaseOutbox, BaseService, entities\Outbox\OutboxInsite, interfaces\RecipientInterface};
use yii\db\Exception;

/**
 * Class InsiteService
 * @package common\components\notificator\services
 *
 * @property string $name
 */
class InsiteService extends BaseService
{
    /**
     * @param BaseOutbox $baseOutbox
     * @return mixed|void
     * @throws Exception
     */
    public function send(BaseOutbox $baseOutbox)
    {
        $outbox = new OutboxInsite();
        $recipients = $baseOutbox->recipients instanceof RecipientInterface ? $baseOutbox->recipients->getAccounts($baseOutbox->type_id) : $baseOutbox->recipients;

        if (!array_key_exists($this->getName(), $recipients)) {
            return;
        }

        // todo: check service/type settings
        if (!$recipients[$this->getName()]) {
            return;
        }

        $outbox->to_id = $baseOutbox->toId;
        $outbox->body = \Yii::$app->view->render($this->_getAbsoluteViewPath($baseOutbox), array_merge(
            $baseOutbox->messageData,
            ['outbox' => $outbox]
        ));
        $outbox->type_id = $baseOutbox->type_id;

        if (!$outbox->save()) {
            throw new Exception(\Yii::t('app', 'Ошибка при сохранении в БД'));
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'insite';
    }
}