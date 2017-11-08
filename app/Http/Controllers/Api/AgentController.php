<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 17-9-25
 * Time: 下午3:31
 */

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Transformers\AgentTransformer;

class AgentController extends BaseController
{
    private $agent;
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function index()
    {
        $agent = $this->agent->paginate();
        return $this->response->paginator($agent, new AgentTransformer());
    }
}