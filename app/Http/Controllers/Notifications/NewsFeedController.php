<?php

namespace App\Http\Controllers\Notifications;

use App\Model\Post;
use App\Model\Wp_term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\AllPostTrait;



class NewsFeedController extends Controller
{
    use AllPostTrait;

    public function getNewsFeed()
    {
        // return $this->allPostswithDetails();

        return $filterd_posts = $this->filterPostsBy('categories', 'Mobile Feed');

    }

/*
|--------------------------------------------------------------------------
| Privet Functions
|--------------------------------------------------------------------------
|
*/
    /**
     * Filter Posts by 
     *  Categories, Tags, Post_formats and news_formats
     */
    private function filterPostsBy($filter, $filter_value)
    {
        $allPosts = $this->allPostswithDetails(); // get this from the trait-> AllPostTrait

        $newsFeed = $allPosts->map(function ($item, $key) use($filter, $filter_value){
            $categories = $item[$filter];
            $returnItem = false;
            foreach ($categories as $category) {
                if ($category == $filter_value) {
                    $returnItem = true;
                    break;
                }
            }
            if ($returnItem) {
                return $item;
            }
        });

        $new_troubledArray = $newsFeed->filter();

        $final_array = [];
        foreach ($new_troubledArray as $key => $value) {
            $final_array[] = $value;
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
            
            foreach ($post->termTaxonomys as $key => $termTaxonomy) {
                switch ($termTaxonomy->taxonomy) {
                    case 'portfolio_category':
                        $portfolio_category[] = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                    case 'portfolio_tags':
                        $portfolio_tags[] = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                    case 'portfolio_skills':
                        $portfolio_skills[] = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                    case 'post_format':
                        $post_format[] = Wp_term::find($termTaxonomy->term_id)->name;
                        break;
                }
                $single_post_details = [
                    'post_id' => $post->ID,
                    'post_title' => $post->post_title,
                    'post_format' => $post_format,
                    'categories' => $portfolio_category,
                    'tags' => $portfolio_tags,
                    'news_format'=> $portfolio_skills
                ];
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

}
