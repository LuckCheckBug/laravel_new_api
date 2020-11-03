<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property string $created_at
 * @property string $updated_at
 */
class UserRole extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_role';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'role_id', 'created_at', 'updated_at'];

    //用户绑定角色（一对多）
    public static function bindRoleUser($data){
        return UserRole::create($data);
    }

    //删除user对应的权限 先删除在创建
    public static function delRoleUser($userId){
        return UserRole::where(['user_id'=>$userId])->delete();
    }

}
