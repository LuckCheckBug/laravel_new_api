<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $project_name
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Project extends Model
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
    protected $table = 're_project';

    /**
     * @var array
     */
    protected $fillable = ['project_name', 'status', 'created_at', 'updated_at'];

    //获取项目列表
    public static function getProjectList(){
        return self::select(['id','project_name'])
            ->orderBy('id','desc')
            ->get();
    }

    //添加项目
    public static function addProject($data){
        return self::create($data);
    }

}
