<?php

namespace App\Http\QueryFilters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class NoRepliesQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // in the current iterating query, we shall chain the following scope to return a filter
        $query->has('posts','=', 0);
    }
}
