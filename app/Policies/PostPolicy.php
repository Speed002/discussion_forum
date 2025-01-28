<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User; 

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    // user can only edit post if the user id = the post_user_id
    public function edit(User $user, Post $post)
    {
        // you can also try using true or false
        return $user->id === $post->user_id;
    }
    // samething with deleting the post
    public function delete(User $user, Post $post)
    {
        // you can also try using true or false
        return $user->id === $post->user_id;
    }
}
