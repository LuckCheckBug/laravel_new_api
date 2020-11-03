<?php

namespace App;

use App\Model\UserRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    //默认的重置密码
    private static $resetPassword = "123456";
    protected $dispatchesEvents = [
        'created'=>\App\Events\CreateEvent::class,
        'deleted'=>\App\Events\DeleteEvent::class,
        'updated'=>\App\Events\UpdateEvent::class,
    ];
    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at' ,'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
        // TODO: Implement getJWTIdentifier() method.
    }

    public function getJWTCustomClaims()
    {
        return [];
        // TODO: Implement getJWTCustomClaims() method.
    }

    //获取条数
    public static function count($where){
        return self::query()->where($where)->count();
    }
    //获取RoleID
    public static function getRoleId(){
        $userId = auth('api')->user()->id;
        $res = UserRole::where(['user_id'=>$userId])->select(['role_id'])->get()->toArray();
        return array_column($res,'role_id');
    }

    //获取用户列表
    public static function UserList($where=[],$perPage=20,$page=1,$columns=['*']){
        return self::where($where)->paginate($perPage,$columns,'page',$page);
    }

    //重置密码
    public static function resetPassword($userId){
        $user = self::find($userId);
        $user->password = Hash::make(self::$resetPassword);
        return $user->save();
    }

    //注册用户
    public static function register($data){
        return self::create($data);
    }


}
