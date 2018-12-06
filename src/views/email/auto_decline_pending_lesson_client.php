<?php
/**
 * @var $this \yii\web\View
 * @var $outbox \common\models\OutboxEmail
 * @var $lesson \common\models\Lessons
 */

$outbox->subject = "No response on lesson request";

?>

<h1><?= $outbox->subject ?></h1>

<p>Tutor did not respond in time. <?= $lesson->slName ?> lesson was cancelled. Your account was not credited.</p>