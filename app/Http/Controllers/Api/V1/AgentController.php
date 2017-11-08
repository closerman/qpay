<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 17-9-25
 * Time: 下午3:31
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\PaginationRequest;
use App\Transformers\AgentTransformer;

class AgentController extends BaseController
{
    use  \App\Http\Requests\ConditionBuild;
    private $builder;

    private $condition;

    public function __construct(Agent $agent)
    {
        $this->builder = $agent;
    }

    /**
     * @api {get} /agents 代理列表(agent list)
     * @apiDescription 代理列表
     * @apiGroup Agent
     * @apiPermission JWT
     * @apiParam {String='{"mobile__like__":"1867%"}'} [condition]  可用的操作符号：'__like__, __lg__,__lt__,__gte__,__lte__,__ne__,__in__,__nin__,__between__'
     * @apiParam {Number='limit'} [limit] 每页显示多少条
     * @apiParam {Number='curpage'}  [curpage] 当前页
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} success-response:
     * HTTP/1.1 200 ok
     * {
    "data": [
    {
    "id": 1,
    "salesman_no": "306063",
    "name": "彭自由",
    "mobile": "13***538",
    "email": "134**8538@qq.com",
    "id_card_number": null,
    "id_card_pic_up": null,
    "id_card_pic_down": null,
    "id_card_pic_with_people": null,
    "province": null,
    "city": null,
    "district": null,
    "address": null,
    "active": "0",
    "audit": "0",
    "status_code": "20A",
    "salesman_status": "10A",
    "created_at": null,
    "updated_at": null
    },
    {
    "id": 2,
    "salesman_no": "294023",
    "name": "黄志楼",
    "mobile": "137***2723",
    "email": "137**2723@qq.com",
    "id_card_number": null,
    "id_card_pic_up": null,
    "id_card_pic_down": null,
    "id_card_pic_with_people": null,
    "province": null,
    "city": null,
    "district": null,
    "address": null,
    "active": "0",
    "audit": "0",
    "status_code": "20A",
    "salesman_status": "10A",
    "created_at": null,
    "updated_at": null
    },
    ],
    "meta": {
    "pagination": {
    "total": 4,
    "count": 4,
    "per_page": 15,
    "current_page": 1,
    "total_pages": 1,
    "links": []
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

        $limit = $request->get('limit', 10);
        $curpage = $request->get('curpage', 1);

        $agent = $this->builder->paginate($limit, null, '', $curpage);
        return $this->response->paginator($agent, new AgentTransformer());
    }
}