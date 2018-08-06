<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'value', 'value_type', 'position'
    ];

    /**
     * Establish the relation between Account and AccountGroup model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountGroup(){
        return $this->belongsTo('App\Models\AccountGroup');
    }

    /**
     * Get the  Value.
     *
     * @param  string  $value
     * @return string
     */
    public function getValueAttribute($value)
    {
        if($this->attributes['value_type'] === 'password'){
            return decrypt($value);
        }else{
            return $value;
        }
    }
}
