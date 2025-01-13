<?php

namespace App\Http\QueryFilters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class TopicQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // in the current iterating query, we shall append the following scope to filter
        // and this is how filters work...
        $query->whereHas('topic', function($query) use ($value){
            $query->where('slug', $value);
        });
    }
}
