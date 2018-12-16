<?php

namespace App\Policies;

use App\User;
use App\Glist;
use Illuminate\Auth\Access\HandlesAuthorization;

class GlistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the glist.
     *
     * @param  \App\User  $user
     * @param  \App\Glist  $glist
     * @return mixed
     */
    public function view(User $user, Glist $glist)
    {
        //
    }

    /**
     * Determine whether the user can create glists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the glist.
     *
     * @param  \App\User  $user
     * @param  \App\Glist  $glist
     * @return mixed
     */
    public function update(User $user, Glist $glist)
    {
        return $glist->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the glist.
     *
     * @param  \App\User  $user
     * @param  \App\Glist  $glist
     * @return mixed
     */
    public function delete(User $user, Glist $glist)
    {
        return $glist->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the glist.
     *
     * @param  \App\User  $user
     * @param  \App\Glist  $glist
     * @return mixed
     */
    public function restore(User $user, Glist $glist)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the glist.
     *
     * @param  \App\User  $user
     * @param  \App\Glist  $glist
     * @return mixed
     */
    public function forceDelete(User $user, Glist $glist)
    {
        //
    }
}
