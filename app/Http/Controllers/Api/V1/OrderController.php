<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 17-9-25
 * Time: 下午3:31
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\PaginationRequest;
use App\Transformers\OrderTransformer;

class OrderController extends BaseController
{
    use  \App\Http\Requests\ConditionBuild;
    private $builder;

    private $condition;

    public function __construct(Order $order)
    {
        $this->builder = $order;
    }

    /**
     * @api {get} /orders 订单列表(orders list)
     * @apiDescription 订单列表
     * @apiGroup Order
     * @apiPermission JWT
     * @apiParam {String='{"mobile__like__":"1867%"}'} [condition]  可用的操作符号：'__like__, __lg__,__lt__,__gte__,__lte__,__ne__,__in__,__nin__,__between__'.记得condition要用encodeURIComponent编码，否则一些特殊字符导致查询到的数据不符合预期
     * @apiParam {Number='limit'} [limit] 每页显示多少条
     * @apiParam {Number='curpage'}  [curpage] 当前页
     * @apiParam {Json='["trxAmount"]'} sum 要求和的字段数组
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} success-response:
     * HTTP/1.1 200 ok
     * {
    {
    "data": [
        {
            "id": 3,
            "agentName": "D深圳市廖闹中支付有",
            "cardNo": "6226388008805032",
            "cardType": "银联贷记卡",
            "depict": null,
            "failureReason": "交易成功",
            "fee": null,
            "addFee": null,
            "machineTerminalId": null,
            "merchantName": "深圳市罗志敏乐购百货",
            "merchantNo": null,
            "merchantProductType": "Qpos",
            "orderCount": null,
            "paymentFlag": "pos刷卡",
            "paymentNo": "2017100922170422571",
            "phone": "13699750558",
            "rateCode": null,
            "salesmanName": "廖闹忠",
            "salesmanPhone": "158***52389",
            "settleMode": "T+0",
            "status": "交易成功",
            "sumFee": null,
            "trxAmount": "8951",
            "trxAmountCount": null,
            "trxSource": null,
            "trxTime": "2017-10-09 22:48:34",
            "trxType": "POS消费",
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 0,
            "agentName": "D深圳市廖闹中支付有",
            "cardNo": "4864945032214119",
            "cardType": "银联贷记卡",
            "depict": null,
            "failureReason": "交易成功",
            "fee": null,
            "addFee": null,
            "machineTerminalId": null,
            "merchantName": "深圳市罗志敏乐购百货",
            "merchantNo": null,
            "merchantProductType": "Qpos",
            "orderCount": null,
            "paymentFlag": "pos刷卡",
            "paymentNo": "2017101220171300695",
            "phone": "136***50558",
            "rateCode": null,
            "salesmanName": "廖闹忠",
            "salesmanPhone": "158***52389",
            "settleMode": "T+0",
            "status": "交易成功",
            "sumFee": null,
            "trxAmount": "6879",
            "trxAmountCount": null,
            "trxSource": null,
            "trxTime": "2017-10-12 20:32:23",
            "trxType": "POS消费",
            "created_at": null,
            "updated_at": null
        }
    ],
    "meta": {
        "sum": {
            "trxAmount": "468626"
        },
        "pagination": {
            "total": 23,
            "count": 2,
            "per_page": 2,
            "current_page": 1,
            "total_pages": 12,
            "links": {
            "next": "http://qpay.net/api/orders?=2"
         }
    }
    }
    }
     */
    public function index(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'condition' => 'json',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }


        if($request->has('condition')) {
            $condition = \GuzzleHttp\json_decode($request->input('condition'), true);
            $this->condition =  $condition;
            $this->addQuery($condition);
        }

        $request->has('sum') and $this->setSum((array)json_decode($request->input('sum'), true));
        if($request->has('sum')) {
            $this->setSum((array)json_decode($request->input('sum'), true));
            $sumData = $this->sum();
        } else {
            $sumData = [];
        }

        //$sumData = $this->sum();

//        dd($sumData);



        $limit = $request->get('limit', 10);
        $curpage = $request->get('curpage', 1);

        $list = $this->builder->paginate($limit, null, '', $curpage);
        return $this->response->paginator($list, new OrderTransformer())->addMeta('sum', $sumData);
    }
}