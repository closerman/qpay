<?php

namespace App\Transformers;

use App\Models\Image;
use App\Models\Document;

use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user','post','document'];

    public function transform(Image $image)
    {
        return $image->attributesToArray();
    }

    public function includeUser(Image $image)
    {
        if (! ($image->user)) {
            return $this->null();
        }

        return $this->item($image->user, new UserTransformer());
    }

    public function includePost(Image $image)
    {
        if(!$image->post) {
            return $this->null();
        }
        return $this->item($image->post, new PostTransformer());
    }

    public function includeDocument(Image $image)
    {
        if($image->document) {
            return $this->item($image->document, new DocumentTransformer());
        }
    }


}
