<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_id
 * @property string $version_name
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Version extends Model
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
    protected $table = 're_version';

    /**
     * @var array
     */
    protected $fillable = ['project_id', 'version_name', 'status', 'created_at', 'updated_at'];


    /**
     * 添加版本
     * @param $data
     * @return mixed
     */
    public static function addVersion($data){
       return self::create($data);
    }

    //获取当前项目所有版本
    public static function getVersionList($where){
        return self::where($where)
            ->select(['version_name','id'])
            ->orderBy('id','desc')
            ->get();
    }

}
