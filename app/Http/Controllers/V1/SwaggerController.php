<?php

namespace App\Http\Controllers\V1;

use App\Features\Api\V1\GetSwaggerPageFeature;
use Lucid\Foundation\Http\Controller;

class SwaggerController extends Controller
{
    /**
     * Render Swagger for the API v1
     *
     * @return mixed
     */
    public function index()
    {
        return $this->serve(GetSwaggerPageFeature::class);
    }
}
