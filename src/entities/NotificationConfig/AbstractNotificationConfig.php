<?php

namespace sorokinmedia\notificator\entities\NotificationConfig;

use sorokinmedia\ar_relations\RelationInterface;
use sorokinmedia\notificator\entities\NotificationType\{AbstractNotificationType};
use sorokinmedia\notificator\interfaces\{NotificationConfigInterface, NotificationTypeInterface};
use Yii;
use yii\db\{ActiveQuery, ActiveRecord, Exception};
use yii\web\IdentityInterface;

/**
 * This is the model class for table "notification_config".
 *
 * @property int $user_id
 * @property int $type_id
 * @property int $sms
 * @property int $telegram
 * @property int $email
 * @property int $in_site
 */
abstract class AbstractNotificationConfig extends ActiveRecord implements RelationInterface, NotificationConfigInterface
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'notification_config';
    }

    /**
     * @param IdentityInterface $user
     * @param NotificationTypeInterface $notificationType
     * @return NotificationConfigInterface
     * @throws Exception
     */
    public static function create(IdentityInterface $user, NotificationTypeInterface $notificationType): NotificationConfigInterface
    {
        /** @var AbstractNotificationType $notificationType */
        $user_notification = self::find()->where(['user_id' => $user->getId(), 'type_id' => $notificationType->id])->one();
        if ($user_notification instanceof NotificationTypeInterface) {
            return $user_notification;
        }
        $user_notification = new static([
            'user_id' => $user->getId(),
            'type_id' => $notificationType->id,
            'email' => $notificationType->email,
            'sms' => $notificationType->sms,
            'telegram' => $notificationType->telegram,
            'in_site' => $notificationType->in_site
        ]);
        $user_notification->checkBeforeConfigSave();
        if (!$user_notification->save()) {
            throw new Exception(Yii::t('app', 'Ошибка при добавлении настройки уведомления пользователю'));
        }
        return $user_notification;
    }

    /**
     * @return void
     */
    abstract public function checkBeforeConfigSave(): void;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'type_id'], 'required'],
            [['user_id', 'type_id', 'sms', 'telegram', 'email', 'in_site'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => Yii::t('app', 'Пользователь'),
            'type_id' => Yii::t('app', 'Тип уведомления'),
            'sms' => Yii::t('app', 'SMS'),
            'telegram' => Yii::t('app', 'Telegram'),
            'email' => Yii::t('app', 'E-mail'),
            'in_site' => Yii::t('app', 'На сайте'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    abstract public function getType(): ActiveQuery;

    /**
     * @return ActiveQuery
     */
    abstract public function getUser(): ActiveQuery;

    /**
     * @param int $in_site
     * @param int $email
     * @param int $sms
     * @param int $telegram
     * @return bool
     * @throws Exception
     */
    public function updateModel(int $in_site, int $email, int $sms, int $telegram): bool
    {
        $this->in_site = $in_site;
        $this->email = $email;
        $this->sms = $sms;
        $this->telegram = $telegram;
        if (!$this->save()) {
            throw new Exception(Yii::t('app', 'Ошибка при обновлении настроек уведомления'));
        }
        return true;
    }
}
