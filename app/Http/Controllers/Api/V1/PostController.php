<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Transformers\PostTransformer;

class PostController extends BaseController
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @api {get} /posts 文章列表(post list)
     * @apiDescription 文章列表(post list)
     * @apiGroup Spread
     * @apiPermission none
     * @apiParam {String='comments:limit(x)','user'} [include]  include
     * @apiParam {Number='limit'} [limit] 每页显示多少条
     * @apiParam {Number='curpage'} [curpage] 当前页
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *     "data": [
     *       {
     *         "id": 1,
     *         "user_id": 3,
     *         "title": "foo",
     *         "content": "",
     *         "created_at": "2016-03-30 15:36:30",
     *         "user": {
     *           "data": {
     *             "id": 3,
     *             "email": "foo@bar.com1",
     *             "name": "",
     *             "avatar": "",
     *             "created_at": "2016-03-30 15:34:01",
     *             "updated_at": "2016-03-30 15:34:01",
     *             "deleted_at": null
     *           }
     *         },
     *         "comments": {
     *           "data": [],
     *           "meta": {
     *             "total": 0
     *           }
     *         }
     *       }
     *     ],
     *     "meta": {
     *       "pagination": {
     *         "total": 2,
     *         "count": 2,
     *         "per_page": 15,
     *         "current_page": 1,
     *         "total_pages": 1,
     *         "links": []
     *       }
     *     }
     *   }
     */
    public function index(Request $request)
    {

        $limit = $request->get('limit', 10);
        $curpage = $request->get('curpage', 1);

        $posts = $this->post->paginate($limit, null ,'', $curpage);

        return $this->response->paginator($posts, new PostTransformer());
    }

    /**
     * @api {get} /user/posts 我的文章列表(my post list)
     * @apiDescription 我的文章列表(my post list)
     * @apiGroup Spread
     * @apiPermission none
     * @apiParam {String='comments:limit(x)'} [include]  include
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *     "data": [
     *       {
     *         "id": 1,
     *         "user_id": 3,
     *         "title": "foo",
     *         "content": "",
     *         "created_at": "2016-03-30 15:36:30",
     *         "user": {
     *           "data": {
     *             "id": 3,
     *             "email": "foo@bar.com1",
     *             "name": "",
     *             "avatar": "",
     *             "created_at": "2016-03-30 15:34:01",
     *             "updated_at": "2016-03-30 15:34:01",
     *             "deleted_at": null
     *           }
     *         },
     *         "comments": {
     *           "data": [],
     *           "meta": {
     *             "total": 0
     *           }
     *         }
     *       }
     *     ],
     *     "meta": {
     *       "pagination": {
     *         "total": 2,
     *         "count": 2,
     *         "per_page": 15,
     *         "current_page": 1,
     *         "total_pages": 1,
     *         "links": []
     *       }
     *     }
     *   }
     */
    public function userIndex()
    {
        $posts = $this->post
            ->where(['user_id' => $this->user()->id])
            ->paginate();

        return $this->response->paginator($posts, new PostTransformer());
    }

    /**
     * @api {get} /posts/{id} 文章详情(post detail)
     * @apiDescription 文章详情(post detail)
     * @apiGroup Spread
     * @apiPermission none
     * @apiParam {String='comments','user'} [include]  include
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *     "data": {
     *       "id": 1,
     *       "user_id": 3,
     *       "title": "foo",
     *       "content": "",
     *       "created_at": "2016-03-30 15:36:30",
     *       "user": {
     *         "data": {
     *           "id": 3,
     *           "email": "foo@bar.com1",
     *           "name": "",
     *           "avatar": "",
     *           "created_at": "2016-03-30 15:34:01",
     *           "updated_at": "2016-03-30 15:34:01",
     *           "deleted_at": null
     *         }
     *       },
     *       "comments": {
     *         "data": [
     *           {
     *             "id": 1,
     *             "post_id": 1,
     *             "user_id": 1,
     *             "reply_user_id": 0,
     *             "content": "foobar",
     *             "created_at": "2016-04-06 14:51:34"
     *           }
     *         ],
     *         "meta": {
     *           "total": 1
     *         }
     *       }
     *     }
     *   }
     */
    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return $this->response->item($post, new PostTransformer());
    }

    /**
     * @api {post} /posts 发布文章(create post)
     * @apiDescription 发布文章(create post)
     * @apiGroup Spread
     * @apiPermission jwt
     * @apiParam {String} title  post title
     * @apiParam {String} content  post content
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 201 Created
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'title' => 'required|string|max:50',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $attributes = $request->only('title', 'content');
        $attributes['user_id'] = $this->user()->id;
        $post = $this->post->create($attributes);

        $location = dingo_route('v1', 'posts.show', $post->id);
        // 返回 201 加数据
        return $this->response
            ->item($post, new PostTransformer())
            //->withHeader('Location', $location) // 可加可不加，参考 Http协议，但是大家一般不适用
            ->setStatusCode(201);
    }

    /**
     * @api {put} /posts/{id} 修改文章(update post)
     * @apiDescription 修改文章(update post)
     * @apiGroup Spread
     * @apiPermission jwt
     * @apiParam {String} title  post title
     * @apiParam {String} content  post content
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 204 NO CONTENT
     */
    public function update($id, Request $request)
    {
        $post = $this->post->findOrFail($id);

        // 不属于我的forbidden
        if ($post->user_id != $this->user()->id) {
            return $this->response->errorForbidden();
        }

        $validator = \Validator::make($request->input(), [
            'title' => 'required|string|max:50',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $post->update($request->only('title', 'content'));

        return $this->response->noContent();
    }

    /**
     * @api {delete} /posts/{id} 删除文章(delete post)
     * @apiDescription 删除文章(delete post)
     * @apiGroup Spread
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 204 NO CONTENT
     */
    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);

        // 不属于我的forbidden
        if ($post->user_id != $this->user()->id) {
            return $this->response->errorForbidden();
        }

        $post->delete();

        return $this->response->noContent();
    }
}
