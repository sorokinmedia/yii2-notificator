<?php

namespace common\models;

/**
 * This is the model class for table "outbox_in_site".
 *
 * @property int $id
 * @property int $status
 * @property string $text
 */
class OutboxInSite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outbox_in_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'text' => 'Text',
        ];
    }
}
