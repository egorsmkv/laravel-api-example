<?php

namespace App\Features\Api;

use App\Domains\Api\Jobs\GetErrorPageJob;
use Lucid\Foundation\Feature;

class GetErrorPageFeature extends Feature
{
    /** @var array<string, mixed> $data */
    private $data;

    /**
     * GetErrorPageFeature constructor.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Handle response for error page
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->run(new GetErrorPageJob($this->data));
    }
}
