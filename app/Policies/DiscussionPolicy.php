<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;

class DiscussionPolicy
{
    /**
     * Create a new policy instance.
     */
    // is a user who is logged in allowed to create a discussion
    public function create(User $user){
        return true; //yes they are
    }
    // is a user allowed to reply to a discussion
    public function reply(User $user, Discussion $discussion){
        return true;
    }
    // is a user allowed to delete a discussion, we only must ensure that their ids match the ids of the Discussions
    public function delete(User $user, Discussion $discussion){
        return $user->id === $discussion->user_id;
    }
    // is a user allowed to delete a discussion, we only must ensure that their ids match the ids of the Discussions
    public function solve(User $user, Discussion $discussion){
        return $user->id === $discussion->user_id;
    }
}
