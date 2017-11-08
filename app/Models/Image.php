<?php

namespace App\Models;

class Image extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'parent_id');
    }
}
