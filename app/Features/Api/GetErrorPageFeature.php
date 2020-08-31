<?php

namespace App\Features\Api;

use App\Domains\Api\Jobs\GetErrorPageJob;
use Lucid\Foundation\Feature;

class GetErrorPageFeature extends Feature
{
    /** @var array $data */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        return $this->run(new GetErrorPageJob($this->data));
    }
}
