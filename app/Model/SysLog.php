<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $value_id
 * @property string $table
 * @property int $user_id
 * @property string $param
 * @property string $original
 * @property string $action
 * @property string $created_at
 */
class SysLog extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sys_log';

    /**
     * @var array
     */
    protected $fillable = ['value_id', 'table', 'user_id', 'param', 'original', 'action', 'created_at'];

}
