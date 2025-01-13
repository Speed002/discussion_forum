<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Models\Discussion;

class PostStoreController extends Controller
{
    public function __invoke(PostStoreRequest $request, Discussion $discussion){
        $post = Post::make($request->validated());

        $post->user()->associate($request->user());
        $post->discussion()->associate($discussion);
        $post->parent()->associate($discussion->post);
        $post->save();
        return redirect(route('discussion.show', $discussion) . '?post=' . $post->id);


    }
}
