<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @property int $id
 * @property string $name
 * @property int $p_id
 * @property string $uri
 * @property string $created_at
 * @property string $updated_at
 */
class Popedom extends Model
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
    protected $table = 'popedom';

    /**
     * @var array
     */
    protected $fillable = ['name', 'p_id', 'uri', 'created_at', 'updated_at'];

    //递归
    public static function sortMenu($menus,$pid=0)
    {
        $arr = [];
        if (empty($menus)) {
            return $menus;
        }
        foreach ($menus as $key => $value) {
            if ($value['p_id'] == $pid) {
                $arr[$key] = $value;
                $arr[$key]['child'] = self::sortMenu($menus,$value['id']);
            }
        }
        return $arr;
    }

    public static function getMenuList($userId){

        $list = UserRole::leftJoin('role as r','user_role.role_id','=','r.id')
            ->select(["r.id","r.type"])
            ->get()->toArray();
        $roleTypeArray = array_column($list,'type');
        if(in_array(0,$roleTypeArray)){
            $menuList = Popedom::select(['id','p_id','name','uri'])
                ->where([['status','=',1]])
                ->orderBy('sort','desc')
                ->get()->toArray();
        }else{
            $roleIdArray = array_column($list,'id');
            $menuList = RolePopedom::join('popedom as p','role_popedom.popedom_id','=','p.id')
                ->whereIn('role_popedom.role_id',$roleIdArray)
                ->where([['p.status','=',1]])
                ->orderBy('p.sort','desc')
                ->select(['p.id','p.p_id','p.name','p.uri'])
                ->get()->toArray();
        }
        $menuList = array_values(self::sortMenu($menuList));
        return $menuList;
    }





}
