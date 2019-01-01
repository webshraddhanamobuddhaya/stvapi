<?php

namespace App\Traits;

use App\Model\Post;

trait AllPostTrait
{
    private function posts()
        {
            $posts = Post::orderBy('post_date', 'desc')
                            ->where('post_status', 'publish')
                            ->where('post_type', 'avada_portfolio')
                            ->take(50)
                            ->get();
            return $posts;
        }

}