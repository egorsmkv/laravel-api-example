<?php

namespace App\Domains\Api\Jobs;

use App\Http\Helpers\PrettyResponse;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Lucid\Foundation\Job;

class GetErrorPageJob extends Job
{
    /** @var PrettyResponse $response */
    private $response;

    /** @var array<string, mixed> $data */
    private $data;

    /**
     * GetErrorPageJob constructor.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());

        $this->response = new PrettyResponse($manager);
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        $code = $this->data['code'];
        $message = $this->data['message'];

        return $this->response
            ->setStatusCode($code)
            ->withArray([
                'api' => $this->data['version'],
                'error' => [
                    'http_code' => $code,
                    'message' => $message
                ]
            ]);
    }
}
