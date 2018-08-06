<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position'
    ];

    /**
     * Establish the relation between Category and Account model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountGroups(){
        return $this->hasMany('App\Models\AccountGroup', 'category_id', 'id');
    }
}
