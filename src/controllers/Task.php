<?php

namespace TaskForce\controllers;

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
    public $idUser;
    public $currentStatus;


    public function __construct(int $idDoer, int $idClient, int $idUser, string $currentStatus)
    {
        $this->idDoer = $idDoer;
        $this->idClient = $idClient;
        $this->idUser = $idUser;
        $this->currentStatus = $currentStatus;
    }

    public function getStatusAll(): array
    {
        return [
            'new' => self::STATUS_NEW,
            'work' => self::STATUS_WORK,
            'cancelled' => self::STATUS_CANCELLED,
            'done' => self::STATUS_DONE,
            'failed' => self::STATUS_FAILED,
        ];
    }

    public function getActionsAll(): array
    {
        return [
            'cancel' => self::ACTION_CANCEL,
            'respond' => self::ACTION_RESPOND,
            'done' => self::ACTION_DONE,
            'refuse' => self::ACTION_REFUSE,
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

    public function getActionsUser(string $currentStatus): ?Action
    {
        switch ($currentStatus) {
            case self::STATUS_NEW:

                $action_cancel = new ActionCancel($this->idDoer, $this->idClient, $this->idUser);

                if ($action_cancel->getAccess()) {
                    return ($action_cancel);
                } else
                    unset($action_cancel);

                $action_done = new ActionDone($this->idDoer, $this->idClient, $this->idUser);
                if ($action_done->getAccess())
                    return ($action_done);
                else
                    unset($action_done);


            case self::STATUS_WORK:
                $action_refuse = new ActionRefuse($this->idDoer, $this->idClient, $this->idUser);
                if ($action_refuse->getAccess())
                    return ($action_refuse);
                else
                    unset($action_refuse);

                $action_respond = new ActionRespond($this->idDoer, $this->idClient, $this->idUser);
                if ($action_respond->getAccess())
                    return ($action_respond);
                else
                    unset($action_respond);

        }
        return NULL;
    }
}

