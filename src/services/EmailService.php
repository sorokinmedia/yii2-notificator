<?php

namespace sorokinmedia\notificator\services;

use sorokinmedia\notificator\{BaseOutbox, BaseService};
use sorokinmedia\notificator\entities\Outbox\AbstractOutboxEmail;
use sorokinmedia\notificator\interfaces\RecipientInterface;
use Yii;
use yii\db\Exception;

/**
 * Class EmailService
 * @package sorokinmedia\notificator\services
 *
 * @property string $name
 */
class EmailService extends BaseService
{
    /**
     * @param BaseOutbox $baseOutbox
     * @param string $class
     * @return bool
     * @throws Exception
     */
    public function send(BaseOutbox $baseOutbox, string $class): bool
    {
        $outbox = new $class;
        $recipients = $baseOutbox->recipients instanceof RecipientInterface ? $baseOutbox->recipients->getAccounts($baseOutbox->type_id) : $baseOutbox->recipients;

        if (!array_key_exists($this->getName(), $recipients)) {
            return true;
        }

        // todo: check service/type settings
        if (!$recipients[$this->getName()]) {
            return true;
        }

        /** @var AbstractOutboxEmail $outbox */
        $outbox->to_email = $recipients[$this->getName()];
        $outbox->to_id = $baseOutbox->to_id;
        $outbox->body = Yii::$app->view->render($this->_getAbsoluteViewPath($baseOutbox), array_merge(
            $baseOutbox->messageData,
            ['outbox' => $outbox]
        ));
        $outbox->from_email = Yii::$app->params['robotEmail'];
        $outbox->status_id = AbstractOutboxEmail::STATUS_SINGLE;
        $outbox->type_id = $baseOutbox->type_id;
        if (!$outbox->isImmediate()) {
            $outbox->status_id = AbstractOutboxEmail::STATUS_GROUP;
        }
        if (!$outbox->save()) {
            throw new Exception(Yii::t('app-sm-notificator', 'Ошибка при сохранении в БД'));
        }
        if ($outbox->isImmediate()) {
            return $outbox->sendOutbox();
        }
        return true;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'email';
    }

    /**
     * @param BaseOutbox $baseOutbox
     * @param string $class
     * @return bool
     */
    public function sendGroup(BaseOutbox $baseOutbox, string $class): bool
    {
        $outbox = new $class;
        $recipients = $baseOutbox->recipients instanceof RecipientInterface ? $baseOutbox->recipients->getAccounts($baseOutbox->type_id) : $baseOutbox->recipients;

        if (is_array($recipients) && !array_key_exists($this->getName(), $recipients)) {
            return true;
        }

        // todo: check service/type settings
        if (!$recipients[$this->getName()]) {
            return true;
        }

        /** @var AbstractOutboxEmail $outbox */
        $outbox->to_email = $recipients[$this->getName()];
        $outbox->to_id = $baseOutbox->to_id;
        $outbox->body = Yii::$app->view->render($this->_getAbsoluteViewPath($baseOutbox), array_merge(
            $baseOutbox->messageData,
            ['outbox' => $outbox]
        ));
        $outbox->from_email = Yii::$app->params['robotEmail'];
        $outbox->status_id = AbstractOutboxEmail::STATUS_SINGLE;
        $outbox->type_id = $baseOutbox->type_id;
        return $outbox->sendGroupOutbox();
    }

    /**
     * @return bool
     */
    public function isGroup(): bool
    {
        return true;
    }
}
