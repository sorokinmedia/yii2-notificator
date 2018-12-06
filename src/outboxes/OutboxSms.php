<?php

namespace common\models;

use common\components\OXActiveRecordTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "outbox_sms".
 *
 * @property int $id
 * @property int $to_id
 * @property int $status
 * @property string $phone
 * @property int $sms_id
 * @property string $body
 * @property string $sent
 * @property string $created
 */
class OutboxSms extends ActiveRecord
{
    use OXActiveRecordTrait;

    const STATUS_NEW = 1;
    const STATUS_SEND = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_ANSWERED = 4;
    const STATUS_FAILED = 5;

    /**
     * @inheritdoc
     */
    public static function tableName()
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
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['status', 'to_id'], 'integer'],
            [['body', 'sms_id'], 'string'],
            [['phone'], 'string', 'max' => 15],
            [['status'], 'default', 'value' => self::STATUS_NEW],
            [['created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to_id' => 'Recipient ID',
            'status' => 'Status',
            'phone' => 'Phone',
            'sms_id' => 'Sms ID',
            'body' => 'Text',
            'sent' => 'Sent at',
        ];
    }
}
