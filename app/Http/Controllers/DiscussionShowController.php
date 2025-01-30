<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\DiscussionResource;

class DiscussionShowController extends Controller
{
    protected const POSTS_PER_PAGE = 5;
    public function __invoke(Request $request, Discussion $discussion){

        if($postId = $request->get('post')){
            return redirect()->route('discussion.show', [
                'discussion' => $discussion,
                'page' => $this->getPageForPost($discussion, $postId),
                'postId' => $postId
            ]);
        }

        // this is helping load the discussion.topic, discussion.solution relationships that connects the discussion model to the topic model
        // since theres no way for eager loading using with make()
        $discussion->load(['topic', 'posts.discussion', 'solution']);
        // above is how we load the relationship with the model when we are in a controller
        return inertia()->render('Forum/Show', [
            'query' => $request->query(),
            'discussion' => DiscussionResource::make($discussion),
            'posts'      => PostResource::collection(
                // from this point we are calling the relationship to connect posts to the discussion they fall under
                Post::whereBelongsTo($discussion)
                ->with(['discussion', 'user'])
                ->oldest()
                ->paginate(self::POSTS_PER_PAGE)
            ),
            // casting the postId into an integer, instead of converting, we can just cast it into an integer
            // Object....(value)
            'postId' => (int) $request->postId,
        ]);
    }

    protected function getPageForPost(Discussion $discussion, $postId){
        $index = $discussion->posts->search(fn ($post) => $post->id == $postId);
        $page  = (int) ceil(($index + 1) / self::POSTS_PER_PAGE);

        return $page;
    }
}
