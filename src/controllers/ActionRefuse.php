<?php

namespace TaskForce\controllers;

class ActionRefuse extends Action
{
    public function getTitle(): string
    {
        return 'ОТКАЗАТЬСЯ';
    }

    public function getVar(): string
    {
        return 'ACTION_REFUSE';
    }

    public function getAccess(): bool
    {
        return $this->user_id === $this->doer_id;
    }
}
