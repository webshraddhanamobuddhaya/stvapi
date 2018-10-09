<?php

namespace App\Model;

use App\Model\MetaData;
use App\Model\TermTaxonomy;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'wp_posts';

    protected $primaryKey = 'ID';

    // Relationship - One to Many with MataData
    public function metadatas()
    {
        return $this->hasMany(MetaData::class,'post_id','ID');
    }

    public function termTaxonomys()
    {
        return $this->belongsToMany(TermTaxonomy::class,'wp_term_relationships','object_id','term_taxonomy_id');
    }

}
