<?php

namespace TaskForce\controllers;

class ActionRespond extends Action
{
    public function getTitle(): string
    {
        return 'ОТКЛИКНУТЬСЯ';
    }

    function getVar(): string
    {
        return 'ACTION_RESPOND';
    }

    function getAccess(): bool
    {
        return $this->user_id === $this->doer_id;
    }
}
