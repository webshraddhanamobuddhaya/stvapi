<?php

namespace App\Model;

use App\Model\Post;
use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    //
    protected $table = 'wp_term_taxonomy';

    protected $primaryKey = 'term_taxonomy_id';


    public function posts()
    {
        return $this->belongsToMany(Post::class,'wp_term_relationships','term_taxonomy_id','object_id');
    }
    
}
