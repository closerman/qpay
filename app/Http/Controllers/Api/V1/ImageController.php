<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Document;
use App\Models\Image;
use App\Transformers\DocumentTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\Cursor;
use App\Transformers\ImageTransformer;
use Illuminate\Support\Facades\Storage;

class ImageController extends BaseController
{
    protected $post;

    protected $document;

    protected $images;

    public function __construct(Image $image, Post $post, Document $document)
    {
        $this->images = $image;

        $this->document = $document;

        $this->post = $post;
    }

    /**
     * @api {get} /images/{type}/{parent_id} 图片列表(post images list)
     * @apiDescription 图片列表(post images list)
     * @apiGroup Spread
     * @apiPermission none
     * @apiParam {String='user','posts', 'document'} include  include
     * @apiParam {String='post，document'} type  类型　
     * @apiParam {String='id'} id  文章或文案id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 200 OK
     *
     *   {
     *       "data": [
     *           {
     *               "id": 6,
     *               "type": "document",
     *               "parent_id": 1,
     *               "user_id": 1,
     *               "url": "2017_10_14/6d88267b3fee2bda19cbd1b7fa4d35805.png",
     *               "created_at": "2017-10-14 15:29:51",
     *               "updated_at": "2017-10-14 15:29:51",
     *               "document": {
     *                   "data": {
     *                       "id": 1,
     *                       "user_id": 1,
     *                       "title": "文案１",
     *                       "content": "这是个文案测试",
     *                       "created_at": "2017-10-14 13:51:53",
     *                       "updated_at": "2017-10-14 13:51:53"
     *                   }
     *               }
     *           }
     *       ],
     *       "meta": {
     *           "pagination": {
     *               "total": 1,
     *               "count": 1,
     *               "per_page": 15,
     *               "current_page": 1,
     *               "total_pages": 1,
     *               "links": []
     *           }
     *       }
     *   }
     *
     *  }
     */
    public function index($type, $id, Request $request)
    {
        $this->images->findOrFail($id);

        $lists = $this->images->where(['parent_id' => $id, 'type' => $type]);

        $currentCursor = $request->get('cursor');

        if ($currentCursor !== null) {
            $currentCursor = (int) $request->get('cursor', null);
            // how to use previous ??
            // $prevCursor = $request->get('previous', null);
            $limit = $request->get('limit', 10);

            $lists = $lists->where([['id', '>', $currentCursor]])->limit($limit)->get();

            $nextCursor = $lists->last()->id;
            $prevCursor = $currentCursor;

            $cursorPatination = new Cursor($currentCursor, $prevCursor, $nextCursor, $lists->count());

            return $this->response->collection($lists, new ImageTransformer(), [], function ($resource) use ($cursorPatination) {
                $resource->setCursor($cursorPatination);
            });
        } else {
            $limit = $request->get('limit', 10);
            $curpage = $request->get('curpage', 1);
            $lists = $lists->paginate($limit, null, '', $curpage);

            return $this->response->paginator($lists, new ImageTransformer());
        }
    }

    /**
     * @api {post} /images/{type}/{parent_id} 添加图片(create image)
     * @apiDescription 添加文章图片(create image)
     * @apiGroup Spread
     * @apiPermission jwt
     * @apiParam {File} file  要上传的图片
     * @apiParam {String="post", "document"} type post是文章，document是文案
     * @apiParam {Number} parent_id 文章或文案的ID
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 201 Created
     *   {
     *   "data": {
     *      "user_id": 1,
     *      "parent_id": "1",
     *      "type": "post",
     *      "url": "public/upload_img/2017_10_14/dfed7b0ae3e9b1d45d31e1a9c64129c45.png",
     *      "updated_at": "2017-10-14 12:07:33",
     *      "created_at": "2017-10-14 12:07:33",
     *      "id": 3
     *     }
     *   }
     *
     *
     */
    public function store($type, $parentId, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'file' => 'required|mimes:png,gif,jpeg,jpg,bmp',
        ]);

         if ($validator->fails()) {
             return $this->errorBadRequest($validator);
         }


         $this->$type->findOrFail($parentId);

        $image = $request->file('file');
        $originalImageName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $newImagesName = md5(time()).random_int(5,5).".$extension";
        $subPath = date('Y_m_d');
        $uploadDirMainPath = 'public/' . env('UPLOAD_PATH') . "/$subPath/";
        $uploadDirMainRealPath = base_path($uploadDirMainPath);


        /*if(!Storage::disk('local')->exists($fullImagePath)) {
            Storage::makeDirectory($fullImagePath);
        }*/

        if(!file_exists($uploadDirMainRealPath)) {
            mkdir($uploadDirMainRealPath, 0755);
        }

        $image->move($uploadDirMainRealPath, $newImagesName);


         $user = $this->user();

         $attributes = [];
         $attributes['user_id'] = $user->id;
         $attributes['parent_id'] = $parentId;
         $attributes['type'] = $type;
         $attributes['url'] = "$uploadDirMainPath/". "$newImagesName";

         $images = $this->images->create($attributes);

         return $this->response->item($images, new ImageTransformer());
    }

    /**
     * @api {delete} /images/{id} 删除图片(delete images)
     * @apiDescription 删除图片(delete images)
     * @apiGroup Spread
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 204 NO CONTENT
     */
    public function destroy($id)
    {
        $user = $this->user();

        $image = $this->images
            ->where(['id' => $id, 'user_id' => $user->id])
            ->findOrFail($id);

        $image->delete();



        return $this->response->noContent();
    }
}
