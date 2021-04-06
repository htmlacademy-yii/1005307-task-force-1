<?php
declare(strict_types=1);

namespace TaskForce\controllers;

class ActionDone extends Action
{
    public function getTitle(): string
    {
        return 'ВЫПОЛНЕНО';
    }

    public function getVar(): string
    {
        return 'ACTION_DONE';
    }

    public function getAccess(): bool
    {
        return $this->user_id === $this->client_id;
    }
}
