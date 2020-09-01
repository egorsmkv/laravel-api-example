<?php

namespace App\Http\Controllers;

use Lucid\Foundation\Http\Controller;

class TestController extends Controller
{
    /**
     * It's just for testing purposes
     *
     * @return string
     */
    public function test1()
    {
        return 'ok';
    }
}
