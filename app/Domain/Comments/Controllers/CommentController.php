<?php

namespace App\Domain\Comments\Controllers;

use App\Domain\Comments\Models\Comment;
use App\Domain\Comments\Resources\CommentResource;
use App\Domain\Threads\Models\Thread;
use Illuminate\Http\Request;

class CommentController
{
    /**
     * GET /api/comments?thread_id=1
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'thread_id' => ['required', 'exists:threads,id'],
        ]);

        $comments = Comment::query()
            ->where('thread_id', $request->thread_id)
            ->whereNull('parent_id')
            ->with([
                'user',
                'replies',
            ])
            ->latest()
            ->get();

        return CommentResource::collection($comments);
    }

    /**
     * POST /api/comments
     *
     * Create:
     * - Root comment
     * - Reply to comment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'thread_id' => ['required', 'exists:threads,id'],
            'body' => ['required', 'string', 'max:5000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        /**
         * Ensure parent comment belongs
         * to the same thread.
         */
        if (! empty($validated['parent_id'])) {

            $parentComment = Comment::findOrFail(
                $validated['parent_id']
            );

            if (
                $parentComment->thread_id !==
                (int) $validated['thread_id']
            ) {
                return response()->json([
                    'message' => 'Parent comment belongs to another thread.',
                ], 422);
            }
        }

        $comment = Comment::create([
            'thread_id' => $validated['thread_id'],
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => 1, // replace with auth()->id() later
            'body' => $validated['body'],
        ]);

        /**
         * Update thread comments count
         */
        Thread::query()
            ->where('id', $validated['thread_id'])
            ->increment('comments_count');

        return new CommentResource(
            $comment
                ->load([
                    'user',
                    'replies',
                ])
                ->loadCount('votes')
        );
    }
}