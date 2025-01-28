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
        // where the discussion has a topic and the topic slug inside the topic has a value as the one passed in
        $query->whereHas('topic', function($query) use ($value){
            $query->where('slug', $value); //look for the slug value in that specific topic, and make sure that slug equals to the value passed from router.visit('/')
        });
    }
}
