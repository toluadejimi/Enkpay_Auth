<?php

namespace App\States\User;

use Spatie\ModelStates\State;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\Attributes\AllowTransition;

#[
    AllowTransition(Activated::class, Deactivated::class),
    AllowTransition(Deactivated::class, Activated::class),
    DefaultState(Activated::class),
]
abstract class UserSuspendedState extends State {}
