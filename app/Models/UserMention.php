<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class UserMention extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'users';

    // since this is a custom user model created, we cant index it as Users,
    // but we have to specify what we are encountering it as
    public function searchableAs()
    {
        // meilisearch will index it as users_mentions
        return 'users_mentions';
    }

    // this is what will be returned once the data is searched
    public function toSearchableArray()
    {
        return [
            'value' => $this->username,
            'label' => $this->name . '(@' . $this->username . ')'
        ];
    }
}
