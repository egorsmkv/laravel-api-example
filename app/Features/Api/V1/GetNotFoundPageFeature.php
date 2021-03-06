<?php

namespace App\Features\Api\V1;

use App\Domains\Api\V1\Jobs\GetNotFoundPageJob;
use Lucid\Foundation\Feature;

class GetNotFoundPageFeature extends Feature
{
    /**
     * Handle response for 404 page
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->run(new GetNotFoundPageJob());
    }
}
