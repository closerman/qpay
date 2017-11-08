<?php

namespace App\Transformers;

use App\Models\Agent;
use League\Fractal\TransformerAbstract;

class AgentTransformer extends TransformerAbstract
{
//    protected $availableIncludes = ['user'];

    public function transform(Agent $comment)
    {
        return $comment->attributesToArray();
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
