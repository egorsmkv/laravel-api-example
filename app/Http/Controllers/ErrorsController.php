<?php

namespace App\Http\Controllers;

use App\Features\Api\GetErrorPageFeature;
use App\Features\Api\GetLoginRequiredPageFeature;
use Lucid\Foundation\Http\Controller;

class ErrorsController extends Controller
{
    /**
     * Show any error
     *
     * @param array<string, string> $data
     *
     * @return mixed
     */
    public function process(array $data)
    {
        return $this->serve(GetErrorPageFeature::class, compact('data'));
    }

    /**
     * Show "login required" page
     *
     * @return mixed
     */
    public function loginRequired()
    {
        return $this->serve(GetLoginRequiredPageFeature::class);
    }
}
