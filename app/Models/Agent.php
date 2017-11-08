<?php

namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Agent extends BaseModel implements AuthenticatableContract, JWTSubject
{

    // 软删除和用户验证attempt
    use SoftDeletes, Authenticatable;

    public $timestamps = false;

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name', 'mobile', 'email','salesman_no', 'status_code', 'salesman_status', 'password'];

    // 查询用户的时候，不暴露密码
    protected $hidden = ['password', 'deleted_at'];

    public function agent()
    {
        return $this->all();
    }

    // jwt 需要实现的方法
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // jwt 需要实现的方法
    public function getJWTCustomClaims()
    {
        return [];
    }

}
