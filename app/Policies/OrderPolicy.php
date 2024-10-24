<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given order can be updated by the user.
     */
    public function update(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}
