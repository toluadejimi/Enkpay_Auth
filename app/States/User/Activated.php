<?php

namespace App\States\User;

class Activated extends UserSuspendedState
{
    protected string $name = 'not-suspended';
}
