<?php

namespace sorokinmedia\notificator\services;

use sorokinmedia\notificator\BaseOutbox;
use sorokinmedia\notificator\BaseService;
use sorokinmedia\notificator\entities\Outbox\AbstractOutboxSms;
use sorokinmedia\notificator\interfaces\RecipientInterface;
use common\models\OutboxSms;
use yii\db\Exception;
use console\jobs\SendSmsJob;

/**
 * Class SmsService
 * @package sorokinmedia\notificator\services
 *
 * @property string $name
 */
class SmsService extends BaseService
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return 'sms';
    }

    /**
     * @param BaseOutbox $baseOutbox
     * @return bool
     * @throws Exception
     */
    public function send(BaseOutbox $baseOutbox): bool
    {
        $outbox = AbstractOutboxSms::create();
        $recipients = $baseOutbox->recipients instanceof RecipientInterface ? $baseOutbox->recipients->getAccounts($baseOutbox->type_id) : $baseOutbox->recipients;

        if (!array_key_exists($this->getName(), $recipients)) {
            return true;
        }

        // todo: check service/type settings
        if (!$recipients[$this->getName()]) {
            return true;
        }

        /** @var AbstractOutboxSms $outbox */
        $outbox->phone = $recipients[$this->getName()];
        $outbox->to_id = $baseOutbox->toId;
        $outbox->body = \Yii::$app->view->render($this->_getAbsoluteViewPath($baseOutbox), array_merge(
            $baseOutbox->messageData,
            ['outbox' => $outbox]
        ));

        if (!$outbox->save()) {
            throw new Exception(\Yii::t('app', 'Ошибка при сохранении в БД'));
        }

        return $outbox->sendOutbox();
    }
}