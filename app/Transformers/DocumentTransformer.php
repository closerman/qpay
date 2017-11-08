<?php

namespace App\Transformers;

use App\Models\Document;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;

class DocumentTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'images', 'recentComments'];

    public function transform(Document $document)
    {
        return $document->attributesToArray();
    }

    public function includeUser(Document $document)
    {
        if (! $document->user) {
            return $this->null();
        }

        return $this->item($document->user, new UserTransformer());
    }

    public function includeImages(Document $document, ParamBag $params = null)
    {
        $limit = 10;
        if ($params->get('limit')) {
            $limit = (array) $params->get('limit');
            $limit = (int) current($limit);
        }

        $images = $document->images()->limit($limit)->get();
        //$total = $document->images()->count();

        return $this->collection($images, new ImageTransformer())
            ->setMeta([
                'limit' => $limit,
                'count' => $images->count(),
                'total' => $document->images()->count(),
            ]);
    }

    /**
     * 列表加载列表不是一件很好的事情，因为dingo的预加载机制
     * 自动预加载include的参数, 所以会读取所有帖子的所有评论
     * 所以可以增加一个recentComments, 增加一个limit条件
     * 但是依然不够完美.
     */
    public function includeRecentComments(Post $post, ParamBag $params = null)
    {
        if ($limit = $params->get('limit')) {
            $limit = (int) current($limit);
        } else {
            $limit = 15;
        }

        $comments = $post->recentComments($limit)->get();

        return $this->collection($comments, new CommentTransformer())
            ->setMeta([
                'limit' => $limit,
                'count' => $comments->count(),
                'total' => $post->comments()->count(),
            ]);
    }
}
