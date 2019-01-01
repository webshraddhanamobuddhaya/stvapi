<?php

namespace App\Http\Controllers\Documentation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentationController extends Controller
{
    public function documentation()
    {
        return [
            'baseUrl'=> 'https://www.shraddha.lk/stvapi/public/',
            'Routes'=> [
                'Latest Videos'=> 'latest_videos',
                'Youtube Live id'=> 'live_id'
            ]
        ];
    }
}
