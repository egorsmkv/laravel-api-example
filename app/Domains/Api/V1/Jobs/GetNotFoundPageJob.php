<?php

namespace App\Domains\Api\V1\Jobs;

use App\Http\Helpers\PrettyResponse;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Lucid\Foundation\Job;

class GetNotFoundPageJob extends Job
{
    /** @var PrettyResponse $response */
    private $response;

    public function __construct()
    {
        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());

        $this->response = new PrettyResponse($manager);
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        return $this->response
            ->setStatusCode(404)
            ->withArray([
                'api' => 'v1',
                'error' => [
                    'code' => $this->response::CODE_NOT_FOUND,
                    'http_code' => 404,
                    'message' => 'Resource Not Found'
                ]
            ]);
    }
}
