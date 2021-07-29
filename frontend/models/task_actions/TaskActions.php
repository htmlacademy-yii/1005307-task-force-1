<?php
declare(strict_types=1);

namespace frontend\models\task_actions;

use frontend\models\{
    responses\Responses
};

class TaskActions
{
    // Задаем список ролей
    public const ROLE_DOER = 'ИСПОЛНИТЕЛЬ';
    public const ROLE_CLIENT = 'ЗАКАЗЧИК';

    public function __construct(int $idClient, int $idUser, int $idDoer = null)
    {
        $this->idDoer = $idDoer;
        $this->idClient = $idClient;
        $this->idUser = $idUser;
    }

    public function nextAction($currentStatus, $role)
    {
        switch ($currentStatus) {
            case 'new':
                return $role == self::ROLE_DOER ? ['title' => 'response', 'name' => 'откликнуться', 'data' => 'response'] : '';
            case 'work':
                return $role == self::ROLE_DOER ? ['title' => 'refusal', 'name' => 'Отказаться', 'data' => 'refuse'] : ['title' => 'request', 'name' => 'Завершить', 'data' => 'complete'];
        }

        return [];
    }

    public function getActionsUser($currentStatus)
    {
        $role = $this->idUser === $this->idClient ? self::ROLE_CLIENT : self::ROLE_DOER;
        return $this->nextAction($currentStatus, $role);
    }
}
