<?php

namespace App\Data\Transformers\Api;

use App\Data\Models\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $item)
    {
        return $item->toArray();
    }
}
