<?php

namespace App\Http\QueryFilters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MineQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // this scope is used to return a specific users criteria or filter... we check to see if the user is logged in first, if they are not, we return nothing... otherwise the query carries on...
        if(!auth()->user()){
            return;
        }
        // in the current iterating query, we shall chain the following the scope to return a proper filter
        $query->whereBelongsTo(auth()->user());
    }
}
    