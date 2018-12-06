<?php
namespace sorokinmedia\notificator\interfaces;

/**
 * Interface RecipientInterface
 * @package sorokinmedia\notificator\interfaces
 */
interface RecipientInterface
{
    /**
     * @return array
     */
    public function getAccounts(): array;
}