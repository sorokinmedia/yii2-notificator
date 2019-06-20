<?php

namespace sorokinmedia\notificator\services;

use sorokinmedia\notificator\{BaseOutbox, BaseService};
use sorokinmedia\notificator\entities\Outbox\AbstractOutboxTelegram;
use sorokinmedia\notificator\interfaces\RecipientInterface;
use Yii;
use yii\db\Exception;

/**
 * Class TelegramService
 * @package common\components\notificator\services
 *
 * @property string $name
 */
class TelegramService extends BaseService
{
    /**
     * @param BaseOutbox $baseOutbox
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

        /** @var AbstractOutboxTelegram $outbox */
        $outbox->to_chat = $recipients[$this->getName()];
        $outbox->to_id = $baseOutbox->to_id;
        $outbox->body = Yii::$app->view->render($this->_getAbsoluteViewPath($baseOutbox), array_merge(
            $baseOutbox->messageData,
            ['outbox' => $outbox]
        ));

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
        return 'telegram';
    }

    /**
     * @return bool
     */
    public function isGroup(): bool
    {
        return false;
    }

    /**
     * @param BaseOutbox $baseOutbox
     * @return bool
     */
    public function sendGroup(BaseOutbox $baseOutbox): bool
    {
        return true;
    }
}
