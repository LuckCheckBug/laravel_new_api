<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $version_id
 * @property string $node_name
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Node extends Model
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
    protected $table = 're_node';

    /**
     * @var array
     */
    protected $fillable = ['version_id', 'node_name', 'status', 'created_at', 'updated_at'];

    /**
     * 添加节点
     * @param $data
     * @return mixed
     */
    public static function addNode($data){
        return self::create($data);
    }

    //删除节点
    public static function delNode(int $node_id){
        $node = self::find($node_id);
        return $node->delete();
    }

    //修改节点
    public static function updateNode(int $node_id,$update){
        $node = self::find($node_id);
        foreach ($update as $key=>$value){
            $node->{$key} = $value;
        }
        return $node->save();
    }

    //获取全部节点
    public static function getNodeList($where){
        return self::where($where)
            ->select(['id','node_name','check_date'])
            ->orderBy('check_date','asc')
            ->get();
    }

    public static function test(){
       return self::query(11)->get();
    }

}
