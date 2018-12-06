<?php
namespace sorokinmedia\notificator\handlers;

use sorokinmedia\notificator\BaseOutbox;
use sorokinmedia\notificator\interfaces\HandlerInterface;

/**
 * Class AutoDeclinePendingLesson
 * @package sorokinmedia\notificator\handlers
 */
class AutoDeclinePendingLesson extends AbstractHandler implements HandlerInterface
{
    /** @var Lessons */
    private $lesson;

    /**
     * ClientRequestLesson constructor.
     *
     * @param Lessons $lesson
     */
    public function __construct(Lessons $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * @return array
     */
    public function getMessageData(): array
    {
        return [
            'lesson' => $this->lesson,
        ];
    }

    /**
     * @return array|BaseOutbox[]
     */
    public function execute()
    {
        $clientOutbox = new BaseOutbox([
            'messageData' => $this->getMessageData(),
            'recipients' => $this->lesson->client,
            'view' => 'auto_decline_pending_lesson_client',
        ]);
        $tutorOutbox = new BaseOutbox([
            'messageData' => $this->getMessageData(),
            'recipients' => $this->lesson->tutor,
            'view' => 'auto_decline_pending_lesson_tutor',
        ]);
        return [$clientOutbox, $tutorOutbox];
    }
}