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

        //for each of the discussions being displayed, we ensure that they have posts eg.
        //$query->whereHas('posts')
        //Now, into each post we are performing queries
        // $query->whereHas('posts', function($query){
            // in each post we are looking through, we want to make sure that the post belongs to the user
            // $query->whereBelongsTo(auth()->user());
        // })

        // IN SHORT:: DOES THIS DISCUSSION HAVE ANY POSTS WHICH BELONG TO THE CURRENTLY AUTHENTICATED USER
        // $query
            //ON TOP OF THE CURRENT ITERATION, WE CAN THEN EXCLUDE ANY POST THAT BELONGS TO US...EG.

        // ->where('user_id', '!=', auth()->id())
        // ->whereHas('posts', function($query){
        //      $query->whereBelongsTo(auth()->user());
        // })
        //and inside the posts
        // where discussion.user_id is not equal to auth()->id()
        // but where the discussion has posts that belong to the auth()->user()
        $query
        ->where('user_id', '!=', auth()->id()) //where user_id on the Discussion table does not belong to the auth-user
        ->whereHas('posts', function($query){ //but inside the posts of the discussion, a post belongs to the auth-user
                $query->whereBelongsTo(auth()->user());
        });
    }
}
