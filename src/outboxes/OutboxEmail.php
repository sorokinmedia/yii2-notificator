<?php

namespace common\models;

use common\components\OXActiveRecordTrait;
use common\queries\OutboxQuery;
use Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;
use yii\mail\MailerInterface;
use yii\mail\MessageInterface;

/**
 * This is the model class for table "outbox".
 *
 * @property integer $id
 * @property integer $to_id
 * @property string $to_email
 * @property string $bcc_email
 * @property string $from_email
 * @property string $subject
 * @property string $body
 * @property string $sent
 * @property string $template
 * @property string $created
 *
 * @property array $toArray
 * @property array $fromArray
 * @property array $bccArray
 * @property array $toEmailsArray
 *
 * @property Users $toUser
 */
class OutboxEmail extends ActiveRecord
{
    use OXActiveRecordTrait;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'outbox_email';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['body'], 'string'],
            [['subject'], 'string', 'max' => 2048],
            [['to_email', 'bcc_email', 'from_email'], 'string', 'max' => 512],
            [
                ['to_id'],
                'exist',
                'skipOnError' => true,
                'skipOnEmpty' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['to_id' => 'id']
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'to_id' => 'To (id)',
            'to_email' => 'To (email)',
            'subject' => 'Subject',
            'body' => 'Body',
            'sent' => 'Sent',
            'template' => 'Template',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'to_id']);
    }

    /**
     * @return OutboxQuery
     */
    public static function find(): OutboxQuery
    {
        return new OutboxQuery(get_called_class());
    }

    /**
     * @param MailerInterface $mailer
     * @return MessageInterface
     */
    public function createMailerMessage(MailerInterface $mailer): MessageInterface
    {
        return $mailer->compose(['html' => '@common/mail/layouts/mail.php', 'text' => '@common/mail/layouts/mail.php'], ['content' => $this->body])
            ->setTo($this->toArray)
            ->setBcc($this->bccArray)
            ->setFrom($this->fromArray)
            ->setSubject($this->subject);
    }

    /**
     * @return array
     */
    public function getBccArray(): array
    {
        if (empty($this->bcc_email)) {
            return [];
        }
        try {
            return Json::decode($this->bcc_email);
        } catch (Exception $e) {
            return [$this->bcc_email];
        }
    }

    /**
     * @param $bcc_array
     */
    public function setBccArray($bcc_array): void
    {
        $this->bcc_email = Json::encode($bcc_array);
    }

    /**
     * @return array
     */
    public function getFromArray(): array
    {
        if (empty($this->from_email)) {
            return [];
        }
        try {
            return Json::decode($this->from_email);
        } catch (Exception $e) {
            return [$this->from_email];
        }
    }

    /**
     * @param $from_array
     */
    public function setFromArray($from_array): void
    {
        $this->from_email = Json::encode($from_array);
    }

    /**
     * @return array
     */
    public function getToArray(): array
    {
        if (empty($this->to_email)) {
            return [];
        }
        try {
            return Json::decode($this->to_email);
        } catch (Exception $e) {
            return [$this->to_email];
        }
    }

    /**
     * @return array
     */
    public function getToEmailsArray(): array
    {
        $result = [];

        foreach ($this->toArray ?? [] as $key => $value) {
            $result[] = is_numeric($key) ? $value : $key;
        }

        return $result;
    }

    /**
     * @param $to_array
     */
    public function setToArray($to_array): void
    {
        $this->to_email = Json::encode($to_array);
    }
}
