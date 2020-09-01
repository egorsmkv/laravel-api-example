<?php

namespace App\Features\Api\V1;

use App\Domains\Api\V1\Jobs\GetArticlesJob;
use App\Domains\Api\V1\Jobs\GetArticlesResponseJob;
use Lucid\Foundation\Feature;

class GetArticlesFeature extends Feature
{
    /**
     * Handle response for "articles" endpoint page
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = $this->run(new GetArticlesJob());

        return $this->run(new GetArticlesResponseJob($articles));
    }
}
