<?php

namespace App\Http\Controllers\V1;

use App\Features\Api\V1\GetArticlesFeature;
use Lucid\Foundation\Http\Controller;

class ArticlesController extends Controller
{
    /**
     * Show "articles" endpoint
     *
     * @return mixed
     */
    public function index()
    {
        return $this->serve(GetArticlesFeature::class);
    }
}
