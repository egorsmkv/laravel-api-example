<?php

namespace App\Http\Controllers;

use App\Features\Api\GetErrorPageFeature;
use App\Features\Api\GetLoginRequiredPageFeature;
use Lucid\Foundation\Http\Controller;

class ErrorsController extends Controller
{
    public function process(array $data)
    {
        return $this->serve(GetErrorPageFeature::class, compact('data'));
    }

    public function loginRequired()
    {
        return $this->serve(GetLoginRequiredPageFeature::class);
    }
}
