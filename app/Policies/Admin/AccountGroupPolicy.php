<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\AccountGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the accountgroup.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccountGroup  $accountgroup
     * @return mixed
     */
    public function view(User $user, AccountGroup $accountgroup)
    {
        return $hasProject = $user->whereHas('assignedProjects', function($query) use($project){
            $query->where('projects.id', $project->id);
        })->count();
    }

    /**
     * Determine whether the user can create accountgroups.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the accountgroup.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccountGroup  $accountgroup
     * @return mixed
     */
    public function update(User $user, AccountGroup $accountgroup)
    {
        //
    }

    /**
     * Determine whether the user can delete the accountgroup.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AccountGroup  $accountgroup
     * @return mixed
     */
    public function delete(User $user, AccountGroup $accountgroup)
    {
        //
    }
}
