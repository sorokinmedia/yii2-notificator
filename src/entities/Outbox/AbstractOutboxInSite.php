<?php

namespace sorokinmedia\notificator\entities\Outbox;

use sorokinmedia\ar_relations\RelationInterface;
use sorokinmedia\notificator\interfaces\OutboxInterface;
use Yii;
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
            [['body', 'template'], 'string'],
            [['created_at', 'is_viewed', 'type_id', 'to_id'], 'integer'],
            [['is_viewed'], 'default', 'value' => 0]
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
            'id' => Yii::t('app-sm-notificator', 'ID'),
            'to_id' => Yii::t('app-sm-notificator', 'Адресат'),
            'type_id' => Yii::t('app-sm-notificator', 'Тип'),
            'to_email' => Yii::t('app-sm-notificator', 'E-mail адрес'),
            'body' => Yii::t('app-sm-notificator', 'Тело письма'),
            'is_viewed' => Yii::t('app-sm-notificator', 'Просмотрено'),
            'template' => Yii::t('app-sm-notificator', 'Шаблон'),
            'created_at' => Yii::t('app-sm-notificator', 'Дата создания'),
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
        $this->is_viewed = 1;
        return $this->save();
    }

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
