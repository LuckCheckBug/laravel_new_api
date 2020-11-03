<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 */
class RolePermission extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'role_permission';

    /**
     * @var array
     */
    protected $fillable = ['role_id', 'permission_id'];

}
