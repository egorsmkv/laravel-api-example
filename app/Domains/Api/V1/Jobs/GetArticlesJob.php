<?php

namespace App\Domains\Api\V1\Jobs;

use App\Data\Models\Article;
use App\Http\Helpers\PerPageHelper;
use Illuminate\Http\Request;
use Lucid\Foundation\Job;

class GetArticlesJob extends Job
{
    /** @var int The default number of items per one page */
    const DEFAULT_ITEMS_PER_PAGE = 10;

    /** @var int[] Allowed items per page */
    private $allowItemsPerPage = [self::DEFAULT_ITEMS_PER_PAGE, 20, 30, 40, 50];

    public function handle(Request $request)
    {
        $perPage = (new PerPageHelper($request, $this->allowItemsPerPage))->get();

        return Article::query()
            ->orderByDesc('id')
            ->paginate($perPage);
    }
}
