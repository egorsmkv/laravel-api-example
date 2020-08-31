<?php

namespace App\Features\Api;

use App\Domains\Api\Jobs\GetLoginRequiredPageJob;
use Lucid\Foundation\Feature;

class GetLoginRequiredPageFeature extends Feature
{
    public function handle()
    {
        return $this->run(new GetLoginRequiredPageJob());
    }
}
