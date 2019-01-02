<?php

namespace App\Http\Controllers\Updates;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Traits
use App\Traits\AllPostTrait;
use App\Traits\SinglePostHelpersTrait;


class UpdatesController extends Controller
{
    use AllPostTrait, SinglePostHelpersTrait;

    public function videos($count=10)
    {
        $forgot_keys = [
            'tags',
            'categories',
            'post_format',
            'news_format'
        ];
        return $this->filterPostsBy('post_format', 'post-format-video', $forgot_keys, $count);

    }
    /**
     * Get News Feed
     */
    public function news($count=10)
    {
        $forgot_keys = [
            'post_format',
            'tags',
            'categories'
        ];
        return $this->filterPostsBy('categories', 'Mobile Feed', $forgot_keys, $count);

    }

    public function audios($count=10)
    {
        return "latest Audios will be comming soon ";
    }
}
