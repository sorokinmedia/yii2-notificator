<?php

namespace sorokinmedia\notificator\entities\Outbox;

use Exception;
use sorokinmedia\ar_relations\RelationInterface;
use sorokinmedia\notificator\interfaces\OutboxInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\{ActiveQuery, ActiveRecord};
use yii\helpers\Json;
use yii\mail\{MailerInterface, MessageInterface};

/**
 * This is the model class for table "outbox".
 *
 * @property integer $id
 * @property integer $to_id
 * @property integer $type_id
 * @property integer $status_id
 * @property string $to_email
 * @property string $from_email
 * @property string $bcc_email
 * @property string $subject
 * @property string $body
 * @property string $sent_at
 * @property string $template
 * @property string $created_at
 *
 * @property array $toArray
 * @property array $fromArray
 * @property array $bccArray
 * @property array $toEmailsArray
 */
abstract class AbstractOutboxEmail extends ActiveRecord implements RelationInterface, OutboxInterface
{
    public const STATUS_SINGLE = 1;
    public const STATUS_GROUP = 2;
    public const STATUS_SEND = 3;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'outbox_email';
    }

    /**
     * @return OutboxInterface
     */
    public static function create(): OutboxInterface
    {
        return new static();
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
            [['to_id'], 'integer'],
            [['status_id'], 'default', 'value' => self::STATUS_SINGLE],
            [['created_at', 'sent_at', 'type_id'], 'integer'],
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
            'status_id' => Yii::t('app', 'Статус'),
            'type_id' => Yii::t('app', 'Тип уведомления'),
            'to_email' => Yii::t('app', 'E-mail'),
            'subject' => Yii::t('app', 'Тема'),
            'body' => Yii::t('app', 'Текст письма'),
            'sent_at' => Yii::t('app', 'Дата отправки'),
            'template' => Yii::t('app', 'Шаблон'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    abstract public function getToUser(): ActiveQuery;

    /**
     * @param MailerInterface $mailer
     * @return MessageInterface
     */
    public function createMailerMessage(MailerInterface $mailer): MessageInterface
    {
        return $mailer->compose(['html' => '@common/mail/layouts/mail.php', 'text' => '@common/mail/layouts/mail.php'], ['content' => $this->body])
            ->setTo($this->toArray)
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

    /**
     * @return bool
     */
    abstract public function sendOutbox(): bool;

    /**
     * @return bool
     */
    abstract public function sendGroupOutbox(): bool;

    /**
     * нужно ли отправлять уведомление сразу или можно отложить до групповой отправки
     * @return bool
     */
    abstract public function isImmediate(): bool;
}
