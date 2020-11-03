<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $role_id
 * @property int $popedom_id
 * @property int $type
 * @property int $create_type
 * @property int $update_type
 * @property int $del_type
 * @property string $created_at
 * @property string $updated_at
 */
class RolePopedom extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'role_popedom';

    /**
     * @var array
     */
    protected $fillable = ['role_id', 'popedom_id', 'type', 'create_type', 'update_type', 'del_type', 'created_at', 'updated_at'];

}
