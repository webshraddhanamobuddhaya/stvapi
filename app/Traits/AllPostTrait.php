<?php

namespace App\Traits;

use App\Model\Post;
use App\Model\Wp_term;

trait AllPostTrait
{
    private function getVidoes()
    {
        return $this->filterPostsBy($filter, $filter_value, $fogot_keys);
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

    /**
     * Filter Posts by 
     *  Categories, Tags, Post_formats and news_formats
     */

    private function filterPostsBy($filter, $filter_value, $fogot_keys,$count)
    {
        $init = 0;
        $count = $count;
        $allPosts = $this->allPostswithDetails(); 

        $newsFeed = $allPosts->map(function ($item, $key) use($filter, $filter_value, $fogot_keys){
            $filters = $item[$filter];
            $returnItem = false;
            // check for the array
            if (is_array($filters)) {
                // Loop through array, if given filter maches inside, return true
                foreach ($filters as $item_filter) {
                    if ($item_filter == $filter_value) {
                        $returnItem = true;
                        break;
                    }
                }
            } else { // if filter is none array, then it is a single value key.
                if($filters == $filter_value) {
                    $returnItem = true;
                }
            }
            // if given filter maches this post
            if ($returnItem) {
                // remove given keys form result
                if(is_array($fogot_keys)){
                    foreach ($fogot_keys as $fogot_key) {
                        $item = $item->forget($fogot_key);
                    }

                }

                return $item;

            }
        });

        $new_troubledArray = $newsFeed->filter();

        $final_array = [];
        foreach ($new_troubledArray as $key => $value) {
            // run increment
            $init++;
            $final_array[] = $value;
            if ($init == $count) {
                break;
            }

        }

        return $final_array;

    }


    /**
     * Combine all values into single post and get all posts
     * 
     * @return Collection allposts
     */
    private function allPostswithDetails()
    {
        $posts = $this->posts();

        //Variables
        $all_posts = collect([]);
        $single_post_details ;
        $portfolio_category = [];
        $portfolio_tags = [];
        $portfolio_skills = [];
        $post_format = [];

        foreach ($posts as $post) {
            $video_url = $this->metadata($post->ID)->video_url;
            $image_url = $this->metadata($post->ID)->image_url;

            foreach ($post->termTaxonomys as $key => $termTaxonomy) {
                switch ($termTaxonomy->taxonomy) {
                    case 'portfolio_category':
                        $portfolio_category[] = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                    case 'portfolio_tags':
                        $portfolio_tags[] = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                    case 'portfolio_skills':
                        // Possible to get all skills. But in our case news feed has only one type.
                        $portfolio_skills = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                    case 'post_format':
                        $post_format = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                }
                $additionalPostDetalis = [
                    'portfolio_category' => $portfolio_category,
                    'portfolio_tags' => $portfolio_tags,
                    'portfolio_skills' => $portfolio_skills,
                    'post_format' => $post_format,
                    'image_url' => $image_url,
                    'video_url' => $video_url,
                    'source' => $this->getSourceType($video_url)

                ];

                $single_post_details = $this->singlePostDetails($post, $additionalPostDetalis,$video_url);

            }
            $all_posts->push(collect($single_post_details));

            //Reset all variables
            $single_post_details = [];
            $portfolio_category = [];
            $portfolio_tags = [];
            $portfolio_skills = [];
            $post_format = [];
        }
        return $all_posts; 
    }

    private function singlePostDetails($post, $additionalPostDetalis)
    {
        return [
            'id' => $post->ID,
            'post_date' => $post->post_date,
            'post_title' => $post->post_title,
            'post_url' => 'https://www.shraddha.lk/shraddha-programs/'. $post->post_name,
            'image_url' => 'https://www.shraddha.lk/wp-content/uploads/'.$additionalPostDetalis['image_url'],
            'video_url' => $additionalPostDetalis['video_url'],
            'source' => $additionalPostDetalis['source'],
            'post_format' => $additionalPostDetalis['post_format'],
            'news_format'=> $additionalPostDetalis['portfolio_skills'],
            'categories' => $additionalPostDetalis['portfolio_category'],
            'tags' => $additionalPostDetalis['portfolio_tags'],
        ];
    }

}