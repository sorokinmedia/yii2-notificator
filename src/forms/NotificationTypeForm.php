<?php

namespace sorokinmedia\notificator\forms;

use sorokinmedia\notificator\entities\NotificationType\AbstractNotificationType;
use yii\base\Model;

/**
 * Class NotificationTypeForm
 * @package sorokinmedia\notificator\forms
 *
 * @property string $name
 * @property string $role
 * @property int $sms
 * @property int $telegram
 * @property int $email
 * @property int $in_site
 */
class NotificationTypeForm extends Model
{
    public $name;
    public $role;
    public $sms;
    public $telegram;
    public $email;
    public $in_site;

    /**
     * NotificationTypeForm constructor.
     * @param array $config
     * @param AbstractNotificationType|null $notificationType
     */
    public function __construct(array $config = [], AbstractNotificationType $notificationType = null)
    {
        if ($notificationType !== null) {
            $this->name = $notificationType->name;
            $this->role = $notificationType->role;
            $this->sms = $notificationType->sms;
            $this->telegram = $notificationType->telegram;
            $this->email = $notificationType->email;
            $this->in_site = $notificationType->in_site;
        }
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'role'], 'required'],
            [['sms', 'telegram', 'email', 'in_site'], 'integer'],
            [['name', 'role'], 'string'],
            [['in_site', 'email',], 'default', 'value' => 1],
            [['sms', 'telegram'], 'default', 'value' => 0],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'name' => \Yii::t('app', 'Название'),
            'role' => \Yii::t('app', 'Роль'),
            'sms' => \Yii::t('app', 'SMS'),
            'email' => \Yii::t('app', 'E-mail'),
            'telegram' => \Yii::t('app', 'Telegram'),
            'in_site' => \Yii::t('app', 'На сайте')
        ];
    }
}