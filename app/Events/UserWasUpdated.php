<?php

namespace App\Events;

use Infrastructure\Events\Event;
use App\User;

class UserWasUpdated extends Event
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
