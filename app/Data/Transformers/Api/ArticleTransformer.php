<?php

namespace App\Data\Transformers\Api;

use App\Data\Models\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * @param Article $item
     * @return array<string, mixed>
     */
    public function transform(Article $item)
    {
        return $item->toArray();
    }
}
