<?php

namespace App\Http\Controllers\V1;

use App\Features\Api\V1\GetSwaggerPageFeature;
use Lucid\Foundation\Http\Controller;

class SwaggerController extends Controller
{
    public function index()
    {
        return $this->serve(GetSwaggerPageFeature::class);
    }
}
