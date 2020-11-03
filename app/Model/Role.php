<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends Model
{
    protected $dispatchesEvents = [
        'created'=>\App\Events\CreateEvent::class,
        'deleted'=>\App\Events\DeleteEvent::class,
        'updated'=>\App\Events\UpdateEvent::class,
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';

    /**
     * @var array
     */
    protected $fillable = ['name', 'type', 'created_at', 'updated_at'];



    //角色列表（分页）
    public static function getRoleList($where=[],$perPage=20,$page=1,$columns=['*']){
        return self::where($where)->paginate($perPage,$columns,'page',$page);
    }

    //添加角色
    public static function addRole($data){
        return self::create($data);
    }

    //删除角色
    public static function delRole(int $roleId){
        $role = self::find($roleId);
        return  $role->delete();
    }

    //获取所有角色
    public static function getAllRole(){
        return self::get()->toArray();
    }

    //修改名称
    public static function updateRole(int $roleId,$update){
        $role = self::find($roleId);
        foreach ($update as $key=>$value){
            $role->{$key} = $value;
        }
        return $role->save();
    }



}
