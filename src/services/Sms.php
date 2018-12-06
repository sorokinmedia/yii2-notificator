<?php

namespace common\components\events\services;

use common\components\events\BaseOutbox;
use common\components\events\BaseService;
use sorokinmedia\notificator\exceptions\NotificatorException;
use common\components\events\interfaces\ServiceInterface;
use common\models\OutboxSms;
use common\models\Users;
use console\jobs\SendSmsJob;

/**
 * Class Sms
 * @package common\components\events\services
 *
 * @property string $name
 */
class Sms extends BaseService implements ServiceInterface
{
    public function getName()
    {
        return 'sms';
    }

    /**
     * @param BaseOutbox $baseOutbox
     *
     * @throws NotificatorException
     */
    public function send(BaseOutbox $baseOutbox)
    {
        $outbox = new OutboxSms();

        $recipients = $baseOutbox->recipients instanceof Users ? $baseOutbox->recipients->getAccounts() : $baseOutbox->recipients;

        if (!array_key_exists($this->getName(), $recipients)) {
            return;
        }

        // todo: check service/type settings
        if (!$recipients[$this->getName()]) {
            return;
        }

        $outbox->phone = $recipients[$this->getName()];
        $outbox->to_id = $baseOutbox->toId;
        $outbox->body = \Yii::$app->view->render($this->_getAbsoluteViewPath($baseOutbox), array_merge(
            $baseOutbox->messageData,
            ['outbox' => $outbox]
        ));

        if (!$outbox->save()) {
            throw new NotificatorException(); // todo
        }

        \Yii::$app->queue->push(new SendSmsJob(['outbox_id' => $outbox->id]));
    }
}