<?php

namespace App\Events;

use Infrastructure\Events\Event;
use App\User;

class UserWasCreated extends Event
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
