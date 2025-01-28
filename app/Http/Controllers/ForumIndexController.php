<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\QueryFilters\MineQueryFilter;
use App\Http\Resources\DiscussionResource;
use App\Http\QueryFilters\TopicQueryFilter;
use App\Http\QueryFilters\SolvedQueryFilter;
use App\Http\QueryFilters\UnsolvedQueryFilter;
use App\Http\QueryFilters\NoRepliesQueryFilter;
use App\Http\QueryFilters\ParticipatingQueryFilter;

class ForumIndexController extends Controller
{
    public function __invoke(Request $request){
        // this gives us back a response after using meilisearch
        // dd(Discussion::search('Laravel')->get());
        // dd($request->search);
        return inertia()->render('Forum/Index', [
            // we are casting the query as an object, to pass it to the vue so that we can build queries with it.
            'query' => (object) $request->query(),
            //you can use with(['model', 'model']) -> this joins more than model
            'discussions' => DiscussionResource::collection(
                // Initiating the querybuilder so we can edit the query
            QueryBuilder::for(Discussion::class)
            ->allowedFilters($this->allowedFilters())
            ->with(['topic', 'post', 'latestPost.user', 'participants'])
            ->withCount('replies') //this returns a column with name replies_count automatically, this column will be pushed to the DiscussionResource to include it in the structure
            ->orderByPinned() //this is scope created in the model to allow us pick an item from the database
            // in a certain criteria, criteria[beginning with thee ones that are pinned]
            ->orderByLastPost()
            // searching with meilisearch using the tap function to tap into the query and inject a command
            ->tap(function($builder) use ($request){
                if(filled($request->search)){
                    return $builder->whereIn('id', Discussion::search($request->search)->get()->pluck('id'));
                }
            })
            ->paginate(10)
            //we append on an instance that we are filtering and our filter results come on more than one page
            //the appends($request->query()) persists the filter in the url, this keeps our url clean and safe from tamper
            ->appends($request->query())
            )
        ]);
    }

    protected function allowedFilters(){
        // this function is returning the allowed filters in here
        return [
            AllowedFilter::custom('noreplies', new NoRepliesQueryFilter()),
            AllowedFilter::custom('mine', new MineQueryFilter()),
            AllowedFilter::custom('participating', new ParticipatingQueryFilter()),
            AllowedFilter::custom('topic', new TopicQueryFilter()),
            AllowedFilter::custom('solved', new SolvedQueryFilter()),
            AllowedFilter::custom('unsolved', new UnsolvedQueryFilter()),
        ];
    }
}
