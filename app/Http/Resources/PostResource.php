<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'body' => $this->body,
            // mark down content is rendered
            'body_markdown' => app(MarkdownRenderer::class)->toHtml($this->body),
            'body_preview' => Str::limit($this->body, 200),
            'user' => PublicUserResource::make($this->whenLoaded('user')),
            'created_at' => DateTimeResource::make($this->created_at),
            'discussion' => DiscussionResource::make($this->whenLoaded('discussion')),
            'user_can' => [
                // auth()->check() -> helps to findout if a user is authenticated or not
                'edit' => auth()->check() && auth()->user()->can('edit', $this->resource),
                'delete' => auth()->check() && auth()->user()->can('delete', $this->resource),
            ],
        ];
    }
}
