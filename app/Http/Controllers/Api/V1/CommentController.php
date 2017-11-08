<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use League\Fractal\Pagination\Cursor;
use App\Transformers\CommentTransformer;

class CommentController extends BaseController
{
    protected $post;

    protected $comment;

    public function __construct(Comment $comment, Post $post)
    {
        $this->comment = $comment;

        $this->post = $post;
    }

    /**
     *
     *   HTTP/1.1 200 OK
     *   {
     *    "data": [
     *      {
     *        "id": 1,
     *        "post_id": 1,
     *        "user_id": 1,
     *        "reply_user_id": 0,
     *        "content": "foobar",
     *        "created_at": "2016-04-06 14:51:34",
     *        "user": {
     *          "data": {
     *            "id": 1,
     *            "email": "foo@bar.com",
     *            "name": "foobar",
     *            "avatar": "",
     *            "created_at": "2016-01-28 07:23:37",
     *            "updated_at": "2016-01-28 07:24:05",
     *            "deleted_at": null
     *          }
     *        }
     *      },
     *      {
     *        "id": 2,
     *        "post_id": 1,
     *        "user_id": 1,
     *        "reply_user_id": 0,
     *        "content": "foobar1",
     *        "created_at": "2016-04-06 15:10:22",
     *        "user": {
     *          "data": {
     *            "id": 1,
     *            "email": "foo@bar.com",
     *            "name": "foobar",
     *            "avatar": "",
     *            "created_at": "2016-01-28 07:23:37",
     *            "updated_at": "2016-01-28 07:24:05",
     *            "deleted_at": null
     *          }
     *        }
     *      },
     *      {
     *        "id": 3,
     *        "post_id": 1,
     *        "user_id": 1,
     *        "reply_user_id": 0,
     *        "content": "foobar2",
     *        "created_at": "2016-04-06 15:10:23",
     *        "user": {
     *          "data": {
     *            "id": 1,
     *            "email": "foo@bar.com",
     *            "name": "foobar",
     *            "avatar": "",
     *            "created_at": "2016-01-28 07:23:37",
     *            "updated_at": "2016-01-28 07:24:05",
     *            "deleted_at": null
     *          }
     *        }
     *      }
     *    ],
     *    "meta": {
     *      "pagination": {
     *        "total": 3,
     *        "count": 3,
     *        "per_page": 15,
     *        "current_page": 1,
     *        "total_pages": 1,
     *        "links": []
     *      }
     *    }
     *  }
     */
    public function index($postId, Request $request)
    {
        $post = $this->post->findOrFail($postId);

        $comments = $this->comment->where(['post_id' => $postId]);

        $currentCursor = $request->get('cursor');

        if ($currentCursor !== null) {
            $currentCursor = (int) $request->get('cursor', null);
            // how to use previous ??
            // $prevCursor = $request->get('previous', null);
            $limit = $request->get('limit', 10);

            $comments = $comments->where([['id', '>', $currentCursor]])->limit($limit)->get();

            $nextCursor = $comments->last()->id;
            $prevCursor = $currentCursor;

            $cursorPatination = new Cursor($currentCursor, $prevCursor, $nextCursor, $comments->count());

            return $this->response->collection($comments, new CommentTransformer(), [], function ($resource) use ($cursorPatination) {
                $resource->setCursor($cursorPatination);
            });
        } else {
            $comments = $comments->paginate();

            return $this->response->paginator($comments, new CommentTransformer());
        }
    }


    public function store($postId, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $post = $this->post->findOrFail($postId);

        $user = $this->user();

        $attributes = $request->only('content');
        $attributes['user_id'] = $user->id;
        $attributes['post_id'] = $postId;

        $this->comment->create($attributes);

        return $this->response->item($comment, new CommentTransformer())
            ->setStatusCode(201);
    }


    public function destroy($postId, $id)
    {
        $user = $this->user();

        $comment = $this->comment
            ->where(['post_id' => $postId, 'user_id' => $user->id])
            ->findOrFail($id);

        $comment->delete();

        return $this->response->noContent();
    }
}
