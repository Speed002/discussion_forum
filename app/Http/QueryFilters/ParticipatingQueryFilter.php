<?php

namespace App\Http\QueryFilters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ParticipatingQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // this filter is used to ensure that the specific user who has logged in has his criteria returned, if not we return nothing to the application
        if(!auth()->user()){
            return;
        }

        // in the current iterating query, we shall append the following code to return a filter
        $query->where('user_id', '!=', auth()->id())
            ->whereHas('posts', function($query){
                $query->whereBelongsTo(auth()->user());
            });
    }
}
