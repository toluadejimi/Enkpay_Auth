<?php

namespace App\States\User;

use Spatie\ModelStates\State;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\Attributes\AllowTransition;

#[
    AllowTransition(Inactive::class, Active::class),
    AllowTransition(Active::class, Inactive::class),
    DefaultState(Inactive::class),
]
abstract class UserStatus extends State {}
