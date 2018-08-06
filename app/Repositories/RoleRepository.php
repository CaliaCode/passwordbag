<?php

namespace App\Repositories;

// Models
use App\Models\Role;

class RoleRepository
{
    /**
     * @var Role
     */
    private $role;

    /**
     * RoleRepository constructor.
     * 
     * @param Role $role
     */
    public function __construct(Role $role) {
        $this->role = $role;
    }

    /**
     * Get the role by the given column and value.
     * 
     * @param $column
     * @param $value
     * @return Role $role
     */
    public function getWhere($column, $value) {
        return Role::where($column, $value)->firstOrFail();
    }

}