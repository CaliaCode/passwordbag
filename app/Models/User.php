<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Establish the relation between User and Role models
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_user')->withTimestamps();
    }

    /**
     * Check if a given role is assigned to the User
     *
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach($this->roles as $role)
        {
            if($role->name == $name) return true;
        }

        return false;
    }

    /**
     * Assign a Role to the User
     *
     * @param $role
     */
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * Remove a Role assigned to the User
     *
     * @param $role
     * @return int
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * Establish the relation between User and UserInfo model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne('App\Models\UserInfo');
    }

    /**
     * Establish the relation between User and Client model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients(){
        return $this->hasMany('App\Models\Client');
    }

    /**
     * Establish the relation between User and Project model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(){
        return $this->hasMany('App\Models\Project');
    }

    /**
     * Establish the relation between User and Project models
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedProjects()
    {
        return $this->belongsToMany('App\Models\Project', 'project_user')->withTimestamps();
    }
}
