<?php

namespace TaskForce\controllers;

class ActionCancel extends Action
{
    public function getTitle(): string
    {
        return 'ОТМЕНИТЬ';
    }

    public function getVar(): string
    {
        return 'ACTION_CANCEL';
    }

    public function getAccess(): bool
    {
        return $this->user_id === $this->client_id;
    }

}
