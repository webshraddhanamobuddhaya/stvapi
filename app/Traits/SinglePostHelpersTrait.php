<?php

namespace App\Traits;

use App\Model\MetaData;

trait SinglePostHelpersTrait
{
    /**
     * Get metadata from post id
     * 
     * @return requested parameter
     */
    private function metadata($postID)
    {
         // Get thumb_id from metadata table
        $metaData_thumb_id = MetaData::where('post_id', $postID)
            ->where('meta_key', '_thumbnail_id')
            ->value('meta_value');
        // Get pyre_video link from matadata table
        $video_url_noneEdit = MetaData::where('post_id', $postID)
            ->where('meta_key', 'pyre_video')
            ->value('meta_value');
        // Get image name from matadata table
        $image_url = MetaData::where('post_id', $metaData_thumb_id)
            ->where('meta_key', "_wp_attached_file")
            ->value('meta_value');

        // fileter url
        $one = str_after($video_url_noneEdit, 'src=');
        $two = str_before($one, 'frameborder=');
        $three = str_after($two, '"');
        $video_url = str_before($three, '"'); // Final video URL

        return (object)[
            'image_url'=> $image_url,
            'video_url'=> $video_url
        ];

    }

    /**
     * Get source type of the post
     * 
     * @return String sourcetype
     */
    private function getSourceType($video_url)
    {
        $url = $video_url;
        $sourceTypes = [
            'youtube' => "www.youtube.com",
            'facebook' => "www.facebook.com",
            'vimeo' => "vimeo"
        ];
        foreach ($sourceTypes as $type => $source) {
            if(str_contains($url,$source) ){
                return $type;
            }
        }
    }
}