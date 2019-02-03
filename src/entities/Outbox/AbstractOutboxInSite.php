<?php

namespace sorokinmedia\notificator\entities\Outbox;

use sorokinmedia\ar_relations\RelationInterface;
use sorokinmedia\notificator\interfaces\OutboxInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\{ActiveQuery, ActiveRecord};

/**
 * This is the model class for table "outbox_in_site".
 *
 * Class AbstractOutboxInSite
 * @package sorokinmedia\notificator\entities\Outbox
 *
 * @property int $id
 * @property int $to_id
 * @property int $type_id
 * @property string $body
 * @property string $viewed
 * @property string $template
 * @property string $created_at
 */
abstract class AbstractOutboxInSite extends ActiveRecord implements RelationInterface, OutboxInterface
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'outbox_insite';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['body'], 'string'],
            [['created_at', 'viewed', 'type_id', 'to_id'], 'integer'],
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
            'id' => \Yii::t('app', 'ID'),
            'to_id' => \Yii::t('app', 'Адресат'),
            'type_id' => \Yii::t('app', 'Тип'),
            'to_email' => \Yii::t('app', 'E-mail адрес'),
            'body' => \Yii::t('app', 'Тело письма'),
            'sent' => \Yii::t('app', 'Отправлено'),
            'template' => \Yii::t('app', 'Шаблон'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getToUser(): ActiveQuery
    {
        return $this->hasOne($this->__userClass, ['id' => 'to_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getType(): ActiveQuery
    {
        return $this->hasOne($this->__notificationTypeClass, ['id' => 'type_id']);
    }

    /**
     * @return bool
     */
    public function checkViewed(): bool
    {
        $this->viewed = time();
        return $this->save();
    }

    /**
     * @return OutboxInterface
     */
    public static function create(): OutboxInterface
    {
        return new static();
    }

    /**
     * @return bool
     */
    abstract public function sendOutbox(): bool;
}
