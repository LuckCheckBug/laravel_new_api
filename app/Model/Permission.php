<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $action
 * @property string $name
 * @property string $method
 */
class Permission extends Model
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
    protected $table = 'permission';

    /**
     * @var array
     */
    protected $fillable = ['action', 'name', 'method'];

}
