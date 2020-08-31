<?php

namespace App\Http\Helpers;

use EllipseSynergie\ApiResponse\AbstractResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Validation\Validator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class PrettyResponse extends AbstractResponse
{
    /**
     * @param array $array
     * @param array $headers
     * @param int $json_options @link http://php.net/manual/en/function.json-encode.php
     *
     * @return mixed
     */
    public function withArray(array $array, array $headers = [], $json_options = 0)
    {
        if ($json_options === 0) {
            $json_options = JSON_PRETTY_PRINT;
        }

        return response()->json($array, $this->statusCode, $headers, $json_options);
    }

    /**
     * Respond with a paginator, and a transformer.
     *
     * @param LengthAwarePaginator $paginator
     * @param callable|TransformerAbstract $transformer
     * @param string|null $resourceKey
     * @param array $meta
     * @return ResponseFactory
     */
    public function withPaginator(LengthAwarePaginator $paginator, $transformer, $resourceKey = null, $meta = [])
    {
        $queryParams = array_diff_key($_GET, array_flip(['page']));
        $paginator->appends($queryParams);

        $resource = new Collection($paginator->items(), $transformer, $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray());
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message from validator
     *
     * @param Validator $validator
     * @return ResponseFactory
     */
    public function errorWrongArgsValidator(Validator $validator)
    {
        return $this->errorWrongArgs($validator->getMessageBag()->toArray());
    }
}
