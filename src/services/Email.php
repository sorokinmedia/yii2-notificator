<?php
namespace sorokinmedia\notificator\services;

use sorokinmedia\notificator\BaseOutbox;
use sorokinmedia\notificator\BaseService;
use sorokinmedia\notificator\exceptions\NotificatorException;
use sorokinmedia\notificator\interfaces\ServiceInterface;
use common\models\OutboxEmail;

/**
 * Class Email
 * @package sorokinmedia\notificator\services
 *
 * @property string $name
 */
class Email extends BaseService implements ServiceInterface
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return 'email';
    }

    /**
     * @param BaseOutbox $baseOutbox
     *
     * @throws NotificatorException
     */
    public function send(BaseOutbox $baseOutbox)
    {
        $outbox = new OutboxEmail();

        $recipients = $baseOutbox->recipients instanceof Users ? $baseOutbox->recipients->getAccounts() : $baseOutbox->recipients;

        if (!array_key_exists($this->getName(), $recipients)) {
            return;
        }

        // todo: check service/type settings
        if (!$recipients[$this->getName()]) {
            return;
        }

        $outbox->to_email = $recipients[$this->name];
        $outbox->to_id = $baseOutbox->toId;
        $outbox->body = \Yii::$app->view->render($this->_getAbsoluteViewPath($baseOutbox), array_merge(
            $baseOutbox->messageData,
            ['outbox' => $outbox]
        ));
        $outbox->from_email = \Yii::$app->params['adminEmail'];

        if (!$outbox->save()) {
            throw new NotificatorException();
        }

        \Yii::$app->queue->push(new SendMailJob(['outbox_id' => $outbox->id]));
    }
}