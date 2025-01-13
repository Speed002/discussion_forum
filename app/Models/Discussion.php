<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Discussion extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',

    ];

    // the boot function allows us to hook into any eloquent events like create, delete and more--------------------------------------------------------------------------------
    protected static function booted()
    {
        // once the created event is hitted up, we are updating a slug immediately as the title of the app...
        static::created(function($discussion){
            // on the current iterating discussion, we want to add the slug after discussion has been created
            $discussion->update(['slug' => $discussion->title]);
        });
    }
    // this function is responsible for setting the slug attribute, before passing it to the static boot function for usage
    // this function setSlugAttribute could be like setBodyAttribute, defining how the specific attribute should look like...
    public function setSlugAttribute($value){
        // this is where the attribute of slug is built from to look like
        $this->attributes['slug'] = $this->id . '-' . Str::slug($value);
    }
    // --------------------------------------------------------------------------------

    // scope for returning pinned at
    public function scopeOrderByPinned($query){
        // you can return on descending order or ascending order as long as the pin shows at the top
        $query->orderBy('pinned_at', 'desc');
    }

    // another scope to return by the latest post
    public function scopeOrderByLastPost($query){
        $query->orderBy(
            Post::select('created_at')->whereColumn('posts.discussion_id', 'discussions.id')->latest()->take(1),
            'desc'
        );
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function isPinned(){
        // this returns the database column pinned_at sets it to not null
        // from the model you can actually access the specific table column you want to access by $this(model) -> table_column
        return !is_null($this->pinned_at);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    // counting replies to this discussion
    public function replies(){
        return $this->hasMany(Post::class)->whereNotNull('parent_id');
    }

    //this is focussing on the first post that is rather the parent post before the child posts
    public function post(){
    return $this->hasOne(Post::class)->whereNull('parent_id');
    }

    public function latestPost(){
        return $this->hasOne(Post::class)->latestOfMany();
    }

    public function participants(){
        // has many users, with many posts,
        return $this->hasManyThrough(User::class, Post::class, 'discussion_id', 'id', 'id', 'user_id')->distinct();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function solution(){
        return $this->belongsTo(Post::class, 'solution_post_id');
    }

    public function toSearchableArray()
    {
        return $this->only('id', 'title');
    }
}
