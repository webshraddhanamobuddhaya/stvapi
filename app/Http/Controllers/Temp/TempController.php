<?php

namespace App\Http\Controllers\Temp;

use App\Model\Post;
use App\Model\Wp_term;

use App\Model\MetaData;
use App\Model\TermTaxonomy;
use Illuminate\Http\Request;
use App\Model\TermRelationships;
use App\Http\Controllers\Controller;


class TempController extends Controller
{
    public function returnPortfolio()
    {
        return $this->returnPortfolioAll('video', 10);
    }

    public function returnPortfolioAll($format, $count)
    {
        $posts = $this->posts();

        $query = $this->query();

        $data;
        
        $count = $count;
        $init = 0;

        foreach ($posts as $post) {
            foreach ($post->termTaxonomys as $data1) {
                if($data1->taxonomy=='post_format'){

                    // Get post format
                    $post_format = substr(Wp_term::find($data1->term_id)->name,12); //post-format-

                    // Get thumbnail id
                    $thumbnail_id = $post->metadatas()->where('meta_key', '_thumbnail_id')->value('meta_value');

                    // Get image url
                    $image_url = MetaData::where('post_id', $thumbnail_id)->where('meta_key', "_wp_attached_file")->value('meta_value');

                    // Get video link 
                    $video_url = $this->filterVideoUrl($post);

                    // Get source type
                    $source = $this->getSourceType($video_url);
                    if($post_format==$format){
                        $init++;
                        $data[] = [
                            // 'term_id' => $data1->term_id,
                            'id' => $post->ID,
                            'post_date' => $post->post_date,
                            'post_title' => $post->post_title,
                            'post_url' => 'https://www.shraddha.lk/shraddha-programs/'. $post->post_name,
                            'image_url' => 'https://www.shraddha.lk/wp-content/uploads/'.$image_url,
                            'video_url' => $video_url,
                            'source' => $source,
                            'post_format' => ucfirst($post_format),
                            // 'init' => $init,
    
                        ];
                        
                    }

                }
            }
            if ($init == $count) break;


        }

        return $data;
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
            'vimeo' => "vimeo",
            'soundcloud' => "w.soundcloud.com"
        ];
        foreach ($sourceTypes as $type => $source) {
            if(str_contains($url,$source) ){
                return $type;
            }
        }
    }

    /**
     * Get video url from mixed url 
     * 
     * @return videourl;
     */
    private function filterVideoUrl($post)
    {
        $video_url_noneEdit = $post->metadatas()->where('meta_key', 'pyre_video')->value('meta_value');

        // fileter url
        $one = str_after($video_url_noneEdit, 'src=');
        $two = str_before($one, 'frameborder=');
        $three = str_after($two, '"');
        $video_url = str_before($three, '"'); // Final video URL

        return $video_url;


    }

    private function termRelationships($postID)
    {
        $postID =$postID;
        $termRelationships = TermRelationships::where('object_id', $postID)->get(['term_taxonomy_id']);

        return $termRelationships;
    }

    private function query()
    {
        $words = 'post-format-';
        $query = Wp_term::where('name', 'like', $words.'%')->get();

        return $query;
    }

    private function posts()
    {
        $posts = Post::orderBy('post_date', 'desc')
                        ->where('post_status', 'publish')
                        ->where('post_type', 'avada_portfolio')
                        ->take(50)
                        ->get();
        return $posts;
    }

    private function termTaxonomy($term_taxonomy_id)
    {
        $data = TermTaxonomy::where('term_taxonomy_id',$term_taxonomy_id)
                                ->where('taxonomy','post_format')
                                ->get();

        return $data;
    }

}
