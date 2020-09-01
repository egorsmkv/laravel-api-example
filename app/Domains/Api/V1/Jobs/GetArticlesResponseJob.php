<?php

namespace App\Domains\Api\V1\Jobs;

use App\Data\Transformers\Api\ArticleTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lucid\Foundation\Job;

class GetArticlesResponseJob extends Job
{
    /** @var LengthAwarePaginator $data */
    private $data;

    public function __construct(LengthAwarePaginator $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        return fractal($this->data, new ArticleTransformer())
            ->withResourceName('article')
            ->respond(200, [], JSON_PRETTY_PRINT);
    }
}
