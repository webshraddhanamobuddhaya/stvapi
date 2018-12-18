<?php

namespace App\Http\Controllers\Notifications;

use App\Model\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function getBanners(){
        $postContent = Post::findOrFail(42429)->post_content;

      
        // Remove markups before content
        $text_after_simble = str_after($postContent, 'id=""]');
        // Remove markups after content
        $content = str_before($text_after_simble, "[/fusion_text]");

        // Split content into array
        $banner_urls = (explode('src="',$content));

        $final =[];

        foreach ($banner_urls as $banner) {
            if(str_contains($banner,'https')){
                $banner = str_before($banner,'"');
                $final[] = $banner;
            }
        }

        
        return response()->json($final);

    }
}
