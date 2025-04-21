<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reservation;

class ReservationPolicy
{
    public function update(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id;
    }

    public function delete(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id;
    }
}
