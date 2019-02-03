<?php
use yii\web\View;
use sorokinmedia\notificator\entities\Outbox\AbstractOutboxEmail;
/** @var $this View */
/** @var $outbox AbstractOutboxEmail */

$outbox->subject = \Yii::t('app', 'Тема письма');

?>
    <h1><?= $outbox->subject ?></h1>
    <p>Текст письма. Тут можно использовать те данные, которые берутся в методе getMessageData()</p>