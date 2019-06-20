<?php

namespace sorokinmedia\notificator\entities\Outbox;

use sorokinmedia\ar_relations\RelationInterface;
use sorokinmedia\notificator\interfaces\OutboxInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\{ActiveQuery, ActiveRecord};

/**
 * This is the model class for table "outbox_telegram".
 *
 * @property integer $id
 * @property integer $to_id
 * @property string $to_chat
 * @property string $body
 * @property string $sent_at
 * @property string $template
 * @property string $created_at
 */
abstract class AbstractOutboxTelegram extends ActiveRecord implements RelationInterface, OutboxInterface
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'outbox_telegram';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['body'], 'string'],
            [['created_at', 'sent_at', 'to_chat', 'to_id'], 'integer'],
            [['body', 'template'], 'string']
        ];
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
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'to_id' => Yii::t('app', 'Адресат'),
            'to_chat' => Yii::t('app', 'ID чата'),
            'body' => Yii::t('app', 'Текст сообщения'),
            'sent_at' => Yii::t('app', 'Дата отправки'),
            'template' => Yii::t('app', 'Шаблон'),
            'created_at' => Yii::t('app', 'Дата создания')
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
     * @return bool
     */
    abstract public function sendGroupOutbox(): bool;

    /**
     * @return bool
     */
    public function isImmediate(): bool
    {
        return true;
    }
}
