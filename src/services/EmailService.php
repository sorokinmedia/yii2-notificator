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
     * @return bool
     * @throws Exception
     */
    public function send(BaseOutbox $baseOutbox): bool
    {
        $outbox = AbstractOutboxEmail::create();
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

        if (!$outbox->save()) {
            throw new Exception(Yii::t('app', 'Ошибка при сохранении в БД'));
        }

        return $outbox->sendOutbox();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'email';
    }
}
