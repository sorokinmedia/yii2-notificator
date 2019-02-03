<?php
namespace sorokinmedia\notificator\interfaces;

/**
 * Interface RecipientInterface
 * @package sorokinmedia\notificator\interfaces
 */
interface RecipientInterface
{
    /**
     * @param int|null $type_id
     * @return array
     */
    public function getAccounts(int $type_id = null): array;
}