<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Requests\DiscussionSolutionPatchRequest;

class DiscussionSolutionPatchController extends Controller
{
    public function __invoke(DiscussionSolutionPatchRequest $request, Discussion $discussion)
    {
        $discussion->solution()->associate(Post::find($request->post_id));
        $discussion->save();
        return back();
    }
}
