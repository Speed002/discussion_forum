<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'replies_count' => $this->replies_count,
            'is_pinned' => $this->isPinned(),
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'post' => PostResource::make($this->whenLoaded('post')),
            'solution' => PostResource::make($this->whenLoaded('solution')),
            'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
            'participants' => PublicUserResource::collection($this->whenLoaded('participants')),
            'user_can' => [
                // auth()->check() -> helps to findout if a user is authenticated or not
                // authenticated user can reply to the discussion
                'reply' => auth()->check() && auth()->user()->can('reply', $this->resource),
                'delete' => auth()->check() && auth()->user()->can('delete', $this->resource),
                'solve' => auth()->check() && auth()->user()->can('solve', $this->resource),
            ],
        ];
    }
}
