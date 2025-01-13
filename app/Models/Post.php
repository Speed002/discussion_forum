<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'body'
    ];

    public function discussion(){
        return $this->belongsTo(Discussion::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function parent(){
        // we can also choose the relating column we want for the model we are relating with like below, laravel doesnt choose that by default
        return $this->belongsTo(Post::class, 'parent_id');
    }
}
