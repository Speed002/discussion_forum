<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscussionRequest;
use App\Models\Discussion;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;

class DiscussionStoreController extends Controller
{
    public function __invoke(StoreDiscussionRequest $request)
    {
        // dd($request->all());
        $discussion = Discussion::make([
            'title' => $request->title
        ]);
        // associate the discussion with the current user, since each discussion has to be under a user
        $discussion->user()->associate($request->user());
        // associate the discussion with a topic since each discussion has a topic (we are pulling in the topic_id from the form)
        $discussion->topic()->associate(Topic::find($request->topic_id));
        $discussion->save();

        // creating a post immediately after creating the discussion
        $post = Post::make([
            'body' => $request->body
        ]);
        // asscociating the post to the user
        $post->user()->associate($request->user());
        // saving the post through the discussion-post relationship
        $discussion->post()->save($post);

        return redirect()->route('discussion.show', $discussion);


    }
}
