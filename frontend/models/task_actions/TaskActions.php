<?php
declare(strict_types=1);

namespace frontend\models\task_actions;

class TaskActions
{
    // Задаем список ролей
    public const ROLE_DOER = 'ИСПОЛНИТЕЛЬ';
    public const ROLE_CLIENT = 'ЗАКАЗЧИК';

    public function __construct(int $idClient, int $idUser, string $currentStatus, int $idDoer = null)
    {
        $this->idDoer = $idDoer;
        $this->idClient = $idClient;
        $this->idUser = $idUser;
        $this->currentStatus = $currentStatus;
    }

    public function nextAction($currentStatus, $role)
    {
        switch ($currentStatus) {
            case 'new':
                return $role == self::ROLE_DOER ? ['title' => 'response', 'name' => 'откликнуться', 'data' => 'refuse'] : '';
            case 'work':
                return $role == self::ROLE_DOER ? ['title' => 'refusal', 'name' => 'Отказаться', 'data' => 'refuse'] : ['title' => 'request', 'name' => 'Завершить', 'data' => 'complete'];
        }

        return [];
    }

    private function isClientOrDoer(): bool
    {
        return $this->idUser === $this->idClient or $this->idUser;
    }

    public function getActionsUser($currentStatus)
    {
        if ($this->isClientOrDoer()) {
            $role = $this->idUser === $this->idClient ? self::ROLE_CLIENT : self::ROLE_DOER;
            return $this->nextAction($currentStatus, $role);
        }
        return [];
    }
}
