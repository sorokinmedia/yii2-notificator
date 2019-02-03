<?php

namespace sorokinmedia\notificator\entities\Outbox;

use sorokinmedia\ar_relations\RelationInterface;
use sorokinmedia\notificator\interfaces\OutboxInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\{ActiveQuery, ActiveRecord};

/**
 * This is the model class for table "outbox_sms".
 *
 * @property int $id
 * @property int $to_id
 * @property int $status_id
 * @property string $phone
 * @property string $body
 * @property string $sent_at
 * @property string $created_at
 */
abstract class AbstractOutboxSms extends ActiveRecord implements RelationInterface, OutboxInterface
{
    const STATUS_NEW = 1;
    const STATUS_SEND = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_ANSWERED = 4;
    const STATUS_FAILED = 5;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'outbox_sms';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['phone'], 'required'],
            [['status_id', 'to_id'], 'integer'],
            [['body'], 'string'],
            [['phone'], 'string', 'max' => 15],
            [['status_id'], 'default', 'value' => self::STATUS_NEW],
            [['created_at', 'sent_at'], 'integer']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'to_id' => \Yii::t('app', 'Получатель'),
            'status_id' => \Yii::t('app', 'Статус'),
            'phone' => \Yii::t('app', 'Номер телефона'),
            'body' => \Yii::t('app', 'Текст сообщения'),
            'sent_at' => \Yii::t('app', 'Дата отправки'),
            'created_at' => \Yii::t('app', 'Дата создания')
        ];
    }

    /**
     * @return ActiveQuery
     */
    abstract public function getToUser(): ActiveQuery;

    /**
     * @return bool
     */
    abstract public function sendOutbox(): bool;

    /**
     * @return OutboxInterface
     */
    public static function create(): OutboxInterface
    {
        return new static();
    }
}