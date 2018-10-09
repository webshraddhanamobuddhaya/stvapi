<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wp_term extends Model
{
    //
    protected $table = 'wp_terms';

    protected $primaryKey = 'term_id';
}
