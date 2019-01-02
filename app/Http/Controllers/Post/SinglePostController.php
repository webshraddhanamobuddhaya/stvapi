<?php

namespace App\Http\Controllers\Post;

use App\Model\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Traits
use App\Traits\SinglePostHelpersTrait;


class SinglePostController extends Controller
{
    use SinglePostHelpersTrait;


    /**
     * Get details of single post
     * 
     * @return single post details
     */
    public function singlePost($id)
    {
        $post = Post::where('ID',$id)->first();

        // Get pyre_video link of single post
        $video_url = $this->metadata($id)->video_url;

        // Single post details with source type
        $singlePost = $this->returnArray($post, $this->getSourceType($video_url));

        // Add description to single post
        $singlePost['description'] = $this->removeMarkup($post->post_content);

        return $singlePost;


    }

    /**
     *  Template of post object
     * 
     *  @return Array 
     */
    private function returnArray($post,$source_type)
    {
        $image_url = $this->metadata($post->ID)->image_url; // Trait function
        $video_url = $this->metadata($post->ID)->video_url; // Trait function
        return  array(
                    'id' => $post->ID,
                    'post_date' => $post->post_date,
                    'post_title' => $post->post_title,
                    'post_url' => 'https://www.shraddha.lk/shraddha-programs/'. $post->post_name,
                    'image_url' => 'https://www.shraddha.lk/wp-content/uploads/'.$image_url,
                    'video_url' => $video_url,
                    'source' => $source_type,
                );
    }

    /**
     * Remove markups from the description of content
     * 
     * @return String paragraph
     */
    private function removeMarkup($postContent)
    {
        //get text after '[fusion_text'
        $text_after_fusionText = str_after($postContent, '[fusion_text');

        //get content after 'id='
        $text_after_id = str_after($text_after_fusionText, 'id=');
        $text_after_simble = str_after($text_after_id, ']');

        $content = strip_tags(str_before($text_after_simble, '[/fusion_text'));
        //remove front and back new lines and spaces
        $finlaContent = trim(preg_replace(' / \s\s + / ', ' ', $content));  
        
        if(str_contains($finlaContent,'[') || str_contains($finlaContent,']') ){
            return '';
        }else{
            return $finlaContent;
        }

    }
}
