<?php

class Task
{

    public const STATUS_NEW = "НОВЫЙ";
    public const STATUS_WORK = 'В РАБОТЕ';
    public const STATUS_CANCELLED = 'ОТМЕНЕНО';
    public const STATUS_DONE = 'ВЫПОЛНЕНО';
    public const STATUS_FAILED = 'ПРОВАЛЕНО';
    public const ACTION_CANCEL = 'ОТМЕНИТЬ';
    public const ACTION_RESPOND = 'ОТКЛИКНУТЬСЯ';
    public const ACTION_DONE = 'ВЫПОЛНЕНО';
    public const ACTION_REFUSE = 'ОТКАЗАТЬСЯ';

    public $idDoer;
    public $idClient;
    public $currentStatus;

    public function __construct(int $idDoer, int $idClient, string $currentStatus)
    {
        $this->idDoer        = $idDoer;
        $this->idClient      = $idClient;
        $this->currentStatus = $currentStatus;
    }

    public function getStatusAll(): array
    {
        return [
            'new'       => self::STATUS_NEW,
            'work'      => self::STATUS_WORK,
            'cancelled' => self::STATUS_CANCELLED,
            'done'      => self::STATUS_DONE,
            'failed'    => self::STATUS_FAILED,
        ];
    }

    public function getActionsAll(): array
    {
        return [
            'cancel'  => self::ACTION_CANCEL,
            'respond' => self::ACTION_RESPOND,
            'done'    => self::ACTION_DONE,
            'refuse'  => self::ACTION_REFUSE,
        ];
    }

    public function getPossibleStatus(string $currentStatus): array
    {
        switch ($currentStatus) {
            case self::STATUS_NEW:
                return ['work' => self::STATUS_WORK, 'canceled' => self::STATUS_CANCELLED];
            case self::STATUS_WORK:
                return ['done' => self::STATUS_DONE, 'failed' => self::STATUS_FAILED];
        }

        return [];
    }

    public function getPossibleActionForClient(string $currentStatus): array
    {
        switch ($currentStatus) {
            case self::STATUS_NEW:
                return ['cancel' => self::ACTION_CANCEL];
            case self::STATUS_WORK:
                return ['done' => self::ACTION_DONE];
        }

        return [];
    }

    public function getPossibleActionForDoer(string $currentStatus): array
    {
        switch ($currentStatus) {
            case self::STATUS_NEW:
                return ['respond' => self::ACTION_RESPOND];
            case self::STATUS_WORK:
                return ['refuse' => self::ACTION_REFUSE];
        }

        return [];
    }
}
