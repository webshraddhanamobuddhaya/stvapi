<?php

namespace App\Http\Controllers\Notifications;

use App\Model\Post;
use App\Model\Wp_term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// Traits
use App\Traits\AllPostTrait;
use App\Traits\SinglePostHelpersTrait;



class NewsFeedController extends Controller
{
    use AllPostTrait,SinglePostHelpersTrait;

    public function getNewsFeed()
    {
        // return $this->allPostswithDetails();
        $forgot_keys = [
            'post_format',
            'tags',
            'categories'
        ];
        return $filterd_posts = $this->filterPostsBy('categories', 'Mobile Feed',$forgot_keys);
        return $filterd_posts = $this->filterPostsBy('categories', 'Mobile Feed');

    }

/*
|--------------------------------------------------------------------------
| Privet Functions
|--------------------------------------------------------------------------
|
*/
    

}
