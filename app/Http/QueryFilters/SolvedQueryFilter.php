<?php

namespace App\Http\QueryFilters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SolvedQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // where the discussion.solution_post_id column is not null
        $query->whereNotNull('solution_post_id');
    }
}
