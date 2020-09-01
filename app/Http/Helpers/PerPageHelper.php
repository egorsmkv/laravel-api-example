<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use InvalidArgumentException;

class PerPageHelper
{
    /** @var string The name of GET-parameter */
    const PARAM_NAME = 'per_page';

    /** @var Request $request */
    private $request;

    /** @var array<int, int> Allowed items of "per page" */
    private $allowed = [];

    /**
     * PerPageHelper constructor.
     *
     * @param Request $request
     * @param array<int, int> $allowed
     */
    public function __construct(Request $request, array $allowed)
    {
        if (empty($allowed)) {
            throw new InvalidArgumentException('allowed parameter is empty');
        }

        $this->request = $request;
        $this->allowed = $allowed;
    }

    /**
     * Get the right choice of the per page value
     *
     * @return integer
     */
    public function get()
    {
        $first = $this->allowed[0];

        $page = $this->request->get(self::PARAM_NAME);
        if (is_array($page) || is_null($page)) {
            return $first;
        }

        $page = (int)abs($page);

        if (!in_array($page, $this->allowed)) {
            return $first;
        }

        return $page;
    }
}
