<?php
declare(strict_types=1);

namespace TaskForce\controllers;

abstract class Action
{
    public function __construct(int $doer_id, int $client_id, int $user_id)
    {
        $this->doer_id = $doer_id;
        $this->client_id = $client_id;
        $this->user_id = $user_id;

    }

    abstract protected function getTitle();

    abstract protected function getVar();

    abstract protected function getAccess(): bool;
}


