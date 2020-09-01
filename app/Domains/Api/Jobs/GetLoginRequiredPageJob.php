<?php

namespace App\Domains\Api\Jobs;

use App\Http\Helpers\PrettyResponse;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Lucid\Foundation\Job;

class GetLoginRequiredPageJob extends Job
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
            ->setStatusCode(401)
            ->withArray([
                'api' => 'unknown',
                'error' => [
                    'code' => $this->response::CODE_UNAUTHORIZED,
                    'http_code' => 401,
                    'message' => 'Unauthorized'
                ]
            ]);
    }
}
