<?php

namespace App\Http\Controllers\V1;

use App\Features\Api\V1\GetArticlesFeature;
use Lucid\Foundation\Http\Controller;

class ArticlesController extends Controller
{
    public function index()
    {
        return $this->serve(GetArticlesFeature::class);
    }
}
