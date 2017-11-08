<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Transformers\DocumentTransformer;

class DocumentController extends BaseController
{
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @api {get} /documents 文案列表(documents list)
     * @apiDescription 文案列表(documents list)
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
     *         "created_at": "2016-03-30 15:36:30",     *
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

        $posts = $this->document->paginate($limit, null, '', $curpage);

        return $this->response->paginator($posts, new DocumentTransformer());
    }

    /**
     * @api {get} /user/documents 文案列表(documents list)
     * @apiDescription 文案列表(documents list)
     * @apiGroup Spread
     * @apiPermission none
     * @apiParam {String='images:limit(x)'} [include]  include
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
        $document = $this->document
            ->where(['user_id' => $this->user()->id])
            ->paginate();

        return $this->response->paginator($document, new PostTransformer());
    }

    /**
     * @api {get} /documents/{id} 文案详情(document detail)
     * @apiDescription 文案详情(document detail)
     * @apiGroup Spread
     * @apiPermission none
     * @apiParam {String='comments:limit(x)','user'} [include]  include
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 200 OK
     *     {
     *      "data": {
     *          "id": 1,
     *          "user_id": 1,
     *          "title": "文案１",
     *           "content": "这是个文案测试",
     *          "created_at": "2017-10-14 13:51:53",
     *          "updated_at": "2017-10-14 13:51:53",
     *          "images": {
     *              "data": [
     *                  {
     *                       "id": 5,
     *                      "type": "document",
     *                      "parent_id": 1,
     *                      "user_id": 1,
     *                      "url": "2017_10_14/a6f5cc7bf1f7dd930be126e77eb5339f5.png",
     *                      "created_at": "2017-10-14 13:53:49",
     *                      "updated_at": "2017-10-14 13:53:49"
     *                  }
     *              ],
     *      "meta": {
     *      "limit": 10,
     *      "count": 1,
     *      "total": 1
     *      }
     *   }
     * }
    }
     */
    public function show($id)
    {
        $document = $this->document->findOrFail($id);

        return $this->response->item($document, new DocumentTransformer());
    }

    /**
     * @api {post} /documents 发布文案(create document)
     * @apiDescription 发布文案(create document)
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
        $document = $this->document->create($attributes);

        //$location = dingo_route('v1', 'posts.show', $post->id);
        // 返回 201 加数据
        return $this->response
            ->item($document, new DocumentTransformer())
            //->withHeader('Location', $location) // 可加可不加，参考 Http协议，但是大家一般不适用
            ->setStatusCode(201);
    }

    /**
     * @api {put} /documents/{id} 修改文案(update document)
     * @apiDescription 修改文案(update document)
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
        $post = $this->document->findOrFail($id);

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
     * @api {delete} /documents/{id} 删除文案(delete document)
     * @apiDescription 删除文案(delete document)
     * @apiGroup Spread
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 204 NO CONTENT
     */
    public function destroy($id)
    {
        $post = $this->document->findOrFail($id);

        // 不属于我的forbidden
        if ($post->user_id != $this->user()->id) {
            return $this->response->errorForbidden();
        }

        $post->delete();

        return $this->response->noContent();
    }
}
