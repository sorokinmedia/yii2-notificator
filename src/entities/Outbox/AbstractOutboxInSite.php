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
 * @property integer $id
 * @property integer $to_id
 * @property integer $type_id
 * @property string $body
 * @property integer $is_viewed
 * @property string $template
 * @property integer $created_at
 */
abstract class AbstractOutboxInSite extends ActiveRecord implements RelationInterface, OutboxInterface
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'outbox_in_site';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['body','template'], 'string'],
            [['created_at', 'is_viewed', 'type_id', 'to_id'], 'integer'],
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
            'is_viewed' => \Yii::t('app', 'Просмотрено'),
            'template' => \Yii::t('app', 'Шаблон'),
            'created_at' => \Yii::t('app', 'Дата создания'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    abstract public function getToUser(): ActiveQuery;

    /**
     * @return ActiveQuery
     */
    abstract public function getType(): ActiveQuery;

    /**
     * @return bool
     */
    public function checkViewed(): bool
    {
        $this->is_viewed = time();
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
