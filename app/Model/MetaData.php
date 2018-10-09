<?php

namespace App\Model;

use App\Model\Post;
use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    protected $table = 'wp_postmeta';

    // Relationship with Post
    public function post(){
        return $this->belongsTo(Post::class,'post_id','ID');
    }
}
