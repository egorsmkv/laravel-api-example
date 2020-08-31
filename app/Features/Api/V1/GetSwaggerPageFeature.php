<?php

namespace App\Features\Api\V1;

use App\Domains\Http\Jobs\RespondWithViewJob;
use Lucid\Foundation\Feature;

class GetSwaggerPageFeature extends Feature
{
    public function handle()
    {
        $url = asset(config('swagger.v1'));

        return $this->run(new RespondWithViewJob('swagger.v1', compact('url')));
    }
}
