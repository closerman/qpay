<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
//    protected $availableIncludes = ['user'];

    public function transform(Order $order)
    {
        return $order->attributesToArray();
    }
/*
    public function includeUser(Agent $comment)
    {
        if (! ($comment->user)) {
            return $this->null();
        }

        return $this->item($comment->user, new UserTransformer());
    }*/
}
