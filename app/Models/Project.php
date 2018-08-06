<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Establish the relation between Project and User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Establish the relation between Project and Client model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    /**
     * Establish the relation between Project and AccountGroup model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountGroups(){
        return $this->hasMany('App\Models\AccountGroup');
    }

    /**
     * Establish the relation between Project and User models
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
//    public function assignedProjects()
//    {
//        return $this->belongsToMany('App\Models\User', 'project_user')->withTimestamps();
//    }
}
