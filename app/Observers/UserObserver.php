<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    // This observer has specific events it is listening to in order to index data that is passed into it as searchable by meilisearch
    // using the relationship mention that has an index to search: we are waiting on the event that a user is created and then the user will be searchable
    public function created(User $user){
        $user->mention->searchable();
    }
    // this is the event of updated
    public function updated(User $user){
        $user->mention->searchable();
    }
}
