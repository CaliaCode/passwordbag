<?php

namespace App\Providers;

use App\Models\AccountGroup;
use App\Models\Project;
use App\Policies\Admin\ProjectPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model'         => 'App\Policies\ModelPolicy',
        Project::class      => ProjectPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Update Profile or Password
        Gate::define('update-profile', function($user, $userId){
            return $user->id == $userId;
        });

        // Access to project
        Gate::define('access-project', function($user, $projectId){
            if (!$user->hasRole('employer')) {
                return true;
            }
            
            return $user->whereHas('assignedProjects', function($query) use($projectId){
                $query->where('projects.id', $projectId);
            })->count();
        });

        // Update AccountGroup
        Gate::define('save-account_group', function($user, $accountGroupId){
            if (!$user->hasRole('employer')) {
                return true;
            }
            
            $accountGroup = AccountGroup::with('project')->find($accountGroupId);
            
            return $user->whereHas('assignedProjects', function($query) use($accountGroup){
                $query->where('projects.id', $accountGroup->project->id);
            })->count();
        });
    }
}
