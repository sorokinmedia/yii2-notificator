<?php
use yii\web\View;
use sorokinmedia\notificator\entities\Outbox\AbstractOutboxTelegram;

/** @var $this View */
/** @var $outbox AbstractOutboxTelegram */

echo "можно использовать #теги и переносы строк\r\nтакже можно использовать данные полученные в методе getMessageData()";