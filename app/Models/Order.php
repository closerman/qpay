<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{

    // 软删除和用户验证attempt
    use SoftDeletes;

    public $timestamps = false;

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ["id", "paymentNo", "merchantName", "merchantNo", "agentName", "cardNo", "trxTime", "status", "trxType", "cardType", "trxAmount", "depict", "orderCount", "trxAmountCount", "rateCode", "phone", "settleMode", "addFee", "sumFee", "salesmanName", "salesmanPhone", "fee", "failureReason", "machineTerminalId", "paymentFlag", "trxSource", "merchantProductType"];

    // 查询用户的时候，不暴露密码
    protected $hidden = ['deleted_at'];

    public function orders()
    {
        return $this->all();
    }



}
