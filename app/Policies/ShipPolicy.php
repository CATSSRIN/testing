<?php

namespace App\Policies;

use App\Models\Ship;
use App\Models\User;

class ShipPolicy
{
    public function update(User $user, Ship $ship): bool
    {
        return $user->id === $ship->user_id;
    }

    public function delete(User $user, Ship $ship): bool
    {
        return $user->id === $ship->user_id;
    }
}
