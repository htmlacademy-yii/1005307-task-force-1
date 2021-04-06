<?php
declare(strict_types=1);

namespace TaskForce\controllers;

use TaskForce\exceptions\StatusException as StatusException;

class Task
{
    // Задаем статусы заданий
    public const STATUS_NEW = "НОВЫЙ";
    public const STATUS_WORK = 'В РАБОТЕ';
    public const STATUS_CANCELLED = 'ОТМЕНЕНО';
    public const STATUS_DONE = 'ВЫПОЛНЕНО';
    public const STATUS_FAILED = 'ПРОВАЛЕНО';

    // Задаем список возможных действий
    public const ACTION_CANCEL = 'ОТМЕНИТЬ';
    public const ACTION_RESPOND = 'ОТКЛИКНУТЬСЯ';
    public const ACTION_DONE = 'ВЫПОЛНЕНО';
    public const ACTION_REFUSE = 'ОТКАЗАТЬСЯ';

    // Задаем список ролей
    public const ROLE_DOER = 'ИСПОЛНИТЕЛЬ';
    public const ROLE_CLIENT = 'ЗАКАЗЧИК';

    public $nextAction = [
        self::STATUS_NEW => [
            self::ROLE_DOER => ActionRespond::class,
            self::ROLE_CLIENT => ActionCancel::class
        ],
        self::STATUS_WORK => [
            self::ROLE_DOER => ActionRefuse::class,
            self::ROLE_CLIENT => ActionDone::class
        ]
    ];

    public function __construct(int $idDoer, int $idClient, int $idUser, string $currentStatus)
    {
        $this->idDoer = $idDoer;
        $this->idClient = $idClient;
        $this->idUser = $idUser;
        if ($currentStatus !== self::STATUS_WORK and $currentStatus !== self::STATUS_CANCELLED and $currentStatus !== self::STATUS_DONE and $currentStatus !== self::STATUS_FAILED and $currentStatus !== self::STATUS_NEW) {
            throw new  StatusException('Задан невозможный текущий статус в конструкторе класса Task');
        }
        $this->currentStatus = $currentStatus;
    }

    private function isClientOrDoer(): bool
    {
        return $this->idUser === $this->idClient or $this->idUser === $this->idDoer;
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
        if ($currentStatus !== self::STATUS_NEW and $currentStatus !== self::STATUS_WORK) {
            throw new  StatusException('Задан невозможный текущий статус в методе getPosibleStatus класса Task');
        }
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
        if ($currentStatus !== self::STATUS_NEW and $currentStatus !== self::STATUS_WORK) {
            throw new  StatusException('Задан невозможный текущий статус в методе getActionsUser класса Task');
        }
        if ($this->isClientOrDoer()) {
            $role = $this->idUser === $this->idClient ? self::ROLE_CLIENT : self::ROLE_DOER;
            return new $this->nextAction[$currentStatus][$role]($this->idDoer, $this->idClient, $this->idUser);
        }
        return null;
    }
}
