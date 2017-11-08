<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 17-10-11
 * Time: 上午11:29
 */

namespace App\Http\Requests;
//use Dingo\Api\Http\Middleware\Request;
use Illuminate\Http\Request;

class PaginationRequest extends Request
{

    public function rules()
    {
        return [
            'condition' => 'json'
        ];
    }
}