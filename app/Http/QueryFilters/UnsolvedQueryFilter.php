<?php

namespace App\Http\QueryFilters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UnsolvedQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // return a discussion where the discussion.solution_post_id is null, in other words is not filled in
        $query->whereNull('solution_post_id');
    }
}
