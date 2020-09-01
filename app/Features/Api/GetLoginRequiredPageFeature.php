<?php

namespace App\Features\Api;

use App\Domains\Api\Jobs\GetLoginRequiredPageJob;
use Lucid\Foundation\Feature;

class GetLoginRequiredPageFeature extends Feature
{
    /**
     * Handle response for "login required" page
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->run(new GetLoginRequiredPageJob());
    }
}
