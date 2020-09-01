<?php

namespace App\Domains\Http\Jobs;

use Illuminate\Http\Response;
use Lucid\Foundation\Job;
use Illuminate\Routing\ResponseFactory;

class RespondWithViewJob extends Job
{
    protected $status;
    protected $data;
    protected $headers;
    protected $template;

    /**
     * RespondWithViewJob constructor.
     *
     * @param string $template
     * @param array $data
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $template, $data = [], $status = 200, array $headers = [])
    {
        $this->template = $template;
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * Handle this job
     *
     * @param ResponseFactory $factory
     *
     * @return Response
     */
    public function handle(ResponseFactory $factory)
    {
        return $factory->view($this->template, $this->data, $this->status, $this->headers);
    }
}
